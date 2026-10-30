<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Payment;
use App\Models\User;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    /**
     * Menampilkan Dashboard Agen
     */
    public function dashboard(Request $request)
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $query = Package::query();

        if ($request->filled('search')) {
            $query->where('nama_paket', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('currency')) {
            $query->where('currency', $request->currency);
        }

        $packages = $query->latest()->get();

        return view('dashboard', compact('packages'));
    }

    public function show($id)
    {
        $package = Package::findOrFail($id);
        $rates = [
            'SAR' => ExchangeRate::where('currency', 'SAR')->first()->rate ?? 4200,
            'USD' => ExchangeRate::where('currency', 'USD')->first()->rate ?? 15800,
            'IDR' => 1
        ];

        $currentRate = $rates[$package->currency] ?? 1;
        $estimasiRupiah = $package->harga_agen * $currentRate;

        return view('user.booking.show', compact('package', 'rates', 'estimasiRupiah'));
    }

    public function create($package_id)
    {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $package = Package::findOrFail($package_id);
        $rateRecord = ExchangeRate::where('currency', $package->currency)->first();
        $currentRate = $rateRecord ? $rateRecord->rate : 4200;

        return view('booking.pendaftaran', compact('package', 'currentRate'));
    }

    /**
     * PROSES PELUNASAN OLEH AGEN (Upload Bukti Baru)
     */
    public function pelunasan(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount_paid' => 'required|numeric|min:1000',
            'metode_bayar' => 'required',
            'proof_of_payment' => 'required|image|max:2048'
        ]);

        return DB::transaction(function () use ($request) {
            $booking = Booking::findOrFail($request->booking_id);

            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->amount_paid = $request->amount_paid;
            $payment->payment_method = $request->metode_bayar;
            $payment->status = 'pending';

            if ($request->hasFile('proof_of_payment')) {
                $filename = 'PAY_' . time() . '_' . $booking->id . '.' . $request->file('proof_of_payment')->getClientOriginalExtension();
                $request->file('proof_of_payment')->storeAs('bukti_bayar', $filename, 'public');
                $payment->proof_of_payment = $filename;
            }
            $payment->save();

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim! Mohon tunggu verifikasi admin.');
        });
    }

    /**
     * PROSES VERIFIKASI PEMBAYARAN OLEH ADMIN
     */
    public function storePayment(Request $request, $id)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:1000',
            'metode_bayar' => 'required',
            'bukti_bayar' => 'nullable|image|max:2048'
        ]);

        return DB::transaction(function () use ($request, $id) {
            $booking = Booking::findOrFail($id);

            $statusFinal = 'pending';
            if ($request->metode_bayar == 'CASH') {
                $statusFinal = 'success';
            } elseif ($request->metode_bayar == 'TRANSFER' && $request->hasFile('bukti_bayar')) {
                $statusFinal = 'success';
            }

            $payment = new Payment();
            $payment->booking_id = $booking->id;
            $payment->amount_paid = $request->nominal;
            $payment->payment_method = $request->metode_bayar;
            $payment->status = $statusFinal;

            if ($request->hasFile('bukti_bayar')) {
                $filename = 'STRUK_' . time() . '_' . $booking->id . '.' . $request->file('bukti_bayar')->getClientOriginalExtension();
                $request->file('bukti_bayar')->storeAs('bukti_bayar', $filename, 'public');
                $payment->proof_of_payment = $filename;
            }
            $payment->save();

            // Bersihkan data pending lama jika ada pembayaran sukses baru
            if ($statusFinal == 'success') {
                $booking->payments()->where('id', '!=', $payment->id)->where('status', 'pending')->delete();
            }

            $booking->refresh();
            $this->syncBookingStatus($booking);

            $message = ($statusFinal == 'success') ? 'Pembayaran berhasil diverifikasi!' : 'Data disimpan, status PENDING.';

            return redirect()->route('booking.invoice', $booking->id)->with('success', $message);
        });
    }

    /**
     * PROSES SIMPAN BOOKING AWAL (Contoh: 3 Orang)
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'nama_group'    => 'required|string|max:255',
            'jumlah_pax'    => 'required|integer|min:1',
            'phone'         => 'required|string|max:20',
        ]);

        $package = Package::findOrFail($id);

        return DB::transaction(function () use ($request, $package) {
            if ($package->sisa_kuota < $request->jumlah_pax) {
                return redirect()->back()->with('error', 'Stok paket tidak mencukupi.');
            }

            $package->decrement('sisa_kuota', $request->jumlah_pax);

            $booking = new Booking();
            $booking->user_id = Auth::id();
            $booking->package_id = $package->id;
            $booking->nama_group = $request->nama_group;
            $booking->jumlah_jamaah = $request->jumlah_pax;
            $booking->status = 'PENDING';
            $booking->total_tagihan = 0;
            $booking->save();

            $booking->details()->create([
                'nama_layanan' => 'PAKET LA / UMROH: ' . $package->nama_paket,
                'qty'          => $request->jumlah_pax,
                'harga'        => $package->harga_agen,
                'keterangan'   => "Pemesanan Awal"
            ]);

            $booking->updateGrandTotal();

            return redirect()->route('booking.invoice', $booking->id);
        });
    }

    /**
     * VALIDASI JAMAAH + SAPU BERSIH PEMBAYARAN TAMBAHAN JIKA JUMLAH TURUN
     */
    public function validateJamaah(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $request->validate([
            'transaction_id' => 'required|exists:bookings,id',
            'real_count' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request) {
            $booking = Booking::with('package', 'details', 'payments')->findOrFail($request->transaction_id);
            $package = $booking->package;
            $realCount = (int) $request->real_count;
            $oldCount = $booking->jumlah_jamaah;

            if ($realCount > $oldCount) {
                // KASUS: JAMAAH BERTAMBAH (3 ke 5)
                $selisihStok = $realCount - $oldCount;
                if ($package->sisa_kuota < $selisihStok) {
                    return redirect()->back()->with('error', 'Stok tidak cukup.');
                }
                $package->decrement('sisa_kuota', $selisihStok);
            } elseif ($realCount < $oldCount) {
                // KASUS: JAMAAH BERKURANG (Balik ke angka awal)
                $selisihStok = $oldCount - $realCount;
                $package->increment('sisa_kuota', $selisihStok);

                // --- LOGIKA PEMBERSIHAN TOTAL ---
                // Sisakan hanya pembayaran pertama (pendaftaran awal), hapus sisanya.
                $pembayaranPertama = $booking->payments()->oldest()->first();
                if ($pembayaranPertama) {
                    $pembayaranTambahan = $booking->payments()
                        ->where('id', '!=', $pembayaranPertama->id)
                        ->get();

                    foreach ($pembayaranTambahan as $pay) {
                        if ($pay->proof_of_payment) {
                            Storage::disk('public')->delete('bukti_bayar/' . $pay->proof_of_payment);
                        }
                        $pay->delete();
                    }
                }
            }

            // Reset Detail Tambahan (Baris Tagihan di Invoice)
            $booking->details()->where('nama_layanan', 'like', '%TAMBAHAN%')->delete();

            $mainDetail = $booking->details()->where('nama_layanan', 'like', '%PAKET LA%')->first();
            $qtyAwal = $mainDetail ? $mainDetail->qty : 0;

            if ($realCount > $qtyAwal) {
                $selisihTagihan = $realCount - $qtyAwal;
                $hargaSatuan = $booking->package->harga_agen;

                $booking->details()->create([
                    'nama_layanan' => 'TAMBAHAN JAMAAH (EXTRA PAX)',
                    'qty'          => $selisihTagihan,
                    'harga'        => $hargaSatuan,
                    'keterangan'   => "Penyesuaian jamaah riil (+ $selisihTagihan Pax)"
                ]);
            }

            $booking->jumlah_jamaah = $realCount;
            $booking->save();

            // Refresh agar status pembayaran yang sudah dihapus tidak terhitung
            $booking = $booking->fresh(['payments']);

            $booking->updateGrandTotal();
            $this->syncBookingStatus($booking);

            return redirect()->back()->with('success', 'Jamaah divalidasi dan data pembayaran disinkronkan.');
        });
    }

    /**
     * Sinkronisasi Status (LUNAS/DP/PENDING)
     */
    private function syncBookingStatus($booking)
    {
        $totalBayarSukses = $booking->payments()->where('status', 'success')->sum('amount_paid');

        if ($booking->total_tagihan > 0 && $totalBayarSukses >= $booking->total_tagihan) {
            $booking->update(['status' => 'LUNAS']);
        } elseif ($totalBayarSukses > 0) {
            $booking->update(['status' => 'DP']);
        } else {
            $booking->update(['status' => 'PENDING']);
        }
    }

    public function riwayat()
    {
        $query = Booking::with(['package', 'payments', 'details'])->withCount('manifests');

        if (Auth::user()->role == 'admin') {
            $bookings = $query->latest()->get();
            return view('admin.riwayat', compact('bookings'));
        } else {
            $bookings = $query->where('user_id', Auth::id())->latest()->get();
            return view('riwayat.index', compact('bookings'));
        }
    }

    public function invoice($id)
    {
        $booking = Booking::with(['package', 'user', 'payments', 'details'])->findOrFail($id);
        $totalDibayar = $booking->payments()->where('status', 'success')->sum('amount_paid');

        return view('booking.invoice', compact('booking', 'totalDibayar'));
    }
}
