<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Cabang;
use App\Models\Artikel;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * FUNGSI PEMBANTU: TERBILANG (Konversi angka ke kata-kata)
     */
    private function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10). " Belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." Puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " Ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " Ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " Juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " Milyar" . $this->penyebut(fmod($nilai,1000000000));
        }
        return $temp;
    }

    /**
     * 1. DASHBOARD ADMIN
     */
    public function index()
    {
        $packages = Package::latest()->get();

        $rawIncome = Booking::whereIn('status', ['LUNAS', 'DP'])
            ->join('packages', 'bookings.package_id', '=', 'packages.id')
            ->select(
                'packages.currency',
                DB::raw('SUM(bookings.total_tagihan) as total_nilai'),
                DB::raw('COUNT(bookings.id) as total_transaksi')
            )
            ->groupBy('packages.currency')
            ->get()
            ->keyBy('currency');

        $dbRates = DB::table('exchange_rates')->get()->pluck('rate', 'currency')->toArray();

        $availableCurrencies = ['IDR', 'SAR', 'USD'];
        $rates = [
            'SAR' => $dbRates['SAR'] ?? 4300,
            'USD' => $dbRates['USD'] ?? 15800,
            'IDR' => 1
        ];

        $incomeByCurrency = [];
        $grandTotalIDR = 0;

        foreach ($availableCurrencies as $cur) {
            $totalVal = $rawIncome->has($cur) ? $rawIncome[$cur]->total_nilai : 0;
            $totalTrans = $rawIncome->has($cur) ? $rawIncome[$cur]->total_transaksi : 0;

            $incomeByCurrency[] = (object)[
                'currency' => $cur,
                'total_nilai' => $totalVal,
                'total_transaksi' => $totalTrans
            ];

            $grandTotalIDR += ($totalVal * $rates[$cur]);
        }

        return view('admin.dashboard', compact('packages', 'incomeByCurrency', 'grandTotalIDR', 'rates'));
    }

    /**
     * 2. CRUD PACKAGES (Paket Umroh)
     */
    public function createPackage()
    {
        return view('admin.packages.create');
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required',
            'harga_agen' => 'required|numeric',
            'currency'   => 'required',
            'category'   => 'required',
            'stok_kursi' => 'required|numeric',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();
        $data['kuota_awal'] = $request->stok_kursi;
        $data['sisa_kuota'] = $request->stok_kursi;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/packages'), $filename);
            $data['image'] = $filename;
        }

        Package::create($data);
        return redirect()->route('admin.dashboard')->with('success', 'Paket berhasil dibuat!');
    }

    public function editPackage($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    public function updatePackage(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'nama_paket' => 'required',
            'harga_agen' => 'required|numeric',
            'currency'   => 'required',
            'category'   => 'required',
            'stok_kursi' => 'required|numeric',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();
        $data['kuota_awal'] = $request->stok_kursi;

        if ($request->hasFile('image')) {
            if ($package->image && File::exists(public_path('uploads/packages/' . $package->image))) {
                File::delete(public_path('uploads/packages/' . $package->image));
            }
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/packages'), $filename);
            $data['image'] = $filename;
        }

        $package->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroyPackage($id)
    {
        $package = Package::findOrFail($id);
        if ($package->image && File::exists(public_path('uploads/packages/' . $package->image))) {
            File::delete(public_path('uploads/packages/' . $package->image));
        }
        $package->delete();
        return back()->with('success', 'Paket berhasil dihapus!');
    }

    /**
     * 3. MANAJEMEN KURS
     */
    public function updateExchangeRate(Request $request)
    {
        $request->validate([
            'currency' => 'required',
            'rate' => 'required|numeric'
        ]);

        DB::table('exchange_rates')->updateOrInsert(
            ['currency' => $request->currency],
            ['rate' => $request->rate, 'updated_at' => now()]
        );

        return back()->with('success', 'Kurs berhasil diperbarui!');
    }

    /**
     * 4. VERIFIKASI PEMBAYARAN
     */
    public function verifikasi(Request $request)
    {
        $query = Booking::with(['user', 'package']);
        if ($request->has('search_id') && $request->search_id != '') {
            $query->where('id', $request->search_id);
        }
        $bookings = $query->latest()->get();
        return view('admin.verifikasi', compact('bookings'));
    }

    public function verify(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'status_verifikasi' => 'required|in:DP,LUNAS',
            'nominal_bayar'     => 'required|numeric'
        ]);

        $booking->status = $request->status_verifikasi;
        $booking->save();

        DB::table('payments')
            ->where('booking_id', $id)
            ->where('status', 'PENDING')
            ->update([
                'status' => 'SUCCESS',
                'amount' => $request->nominal_bayar,
                'updated_at' => now()
            ]);

        return back()->with('success', "Pembayaran ID #{$id} Berhasil Diverifikasi!");
    }

    /**
     * 5. CETAK KWITANSI & MANIFEST
     */
    public function cetakKwitansi($id)
    {
        $booking = Booking::with(['package', 'user'])->findOrFail($id);
        if ($booking->status == 'PENDING') {
            return back()->with('error', "Verifikasi pembayaran terlebih dahulu.");
        }

        $satuan = ($booking->package->currency == 'IDR') ? 'Rupiah' : (($booking->package->currency == 'SAR') ? 'Riyal' : 'Dollar');
        $terbilang = trim($this->penyebut($booking->total_tagihan)) . " " . $satuan;
        $nama_admin = Auth::user()->name;

        return view('admin.packages.kwitansi', compact('booking', 'terbilang', 'nama_admin'));
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        if ($booking->bukti_bayar && File::exists(storage_path('app/public/bukti_bayar/' . $booking->bukti_bayar))) {
            File::delete(storage_path('app/public/bukti_bayar/' . $booking->bukti_bayar));
        }

        $booking->update(['status' => 'PENDING', 'bukti_bayar' => null]);
        return back()->with('error', "Pembayaran ID #{$id} ditolak.");
    }

    public function show($id)
    {
        $booking = Booking::with(['package', 'user', 'manifests'])->findOrFail($id);
        return view('admin.show_manifest', compact('booking'));
    }

    /**
     * 6. TRANSPORTASI
     */
    public function indexTransport()
    {
        return view('admin.transport.index');
    }

    /**
     * 7. MANAJEMEN CABANG (Menggunakan Modal)
     */
    public function indexCabang()
    {
        $cabangs = Cabang::all();
        return view('admin.cabang.index', compact('cabangs'));
    }

    public function storeCabang(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required',
            'lokasi' => 'required',
            'total_agen' => 'required|integer',
        ]);

        Cabang::create($request->all());
        return redirect()->back()->with('success', 'Cabang baru berhasil ditambahkan!');
    }

    public function updateCabang(Request $request, $id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->update($request->all());
        return redirect()->back()->with('success', 'Data cabang berhasil diperbarui!');
    }

    public function destroyCabang($id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->delete();
        return redirect()->back()->with('success', 'Cabang telah berhasil dihapus!');
    }

    /**
     * 8. MANAJEMEN ARTIKEL (PERBAIKAN PAGINATION)
     */
    public function indexArtikel()
    {
        // PERBAIKAN: Gunakan paginate() bukan get() agar fungsi ->links() di Blade tidak error
        $artikels = Artikel::latest()->paginate(9);
        return view('admin.artikel.index', compact('artikels'));
    }

    public function createArtikel()
    {
        return view('admin.artikel.create');
    }

    public function storeArtikel(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar yang diizinkan: JPG, JPEG, PNG.',
            'gambar.max'   => 'Ukuran gambar maksimal 2MB.'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/artikel'), $filename);
            $data['gambar'] = $filename;
        }

        Artikel::create($data);
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function editArtikel($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function updateArtikel(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($artikel->gambar && File::exists(public_path('uploads/artikel/' . $artikel->gambar))) {
                File::delete(public_path('uploads/artikel/' . $artikel->gambar));
            }
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/artikel'), $filename);
            $data['gambar'] = $filename;
        }

        $artikel->update($data);
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroyArtikel($id)
    {
        $artikel = Artikel::findOrFail($id);
        if ($artikel->gambar && File::exists(public_path('uploads/artikel/' . $artikel->gambar))) {
            File::delete(public_path('uploads/artikel/' . $artikel->gambar));
        }
        $artikel->delete();
        return back()->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * 9. MANAJEMEN KONTAK (Pesan Masuk)
     */
    public function indexKontak()
    {
        $pesans = Kontak::latest()->get();
        return view('admin.kontak.index', compact('pesans'));
    }

    public function destroyKontak($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->delete();
        return back()->with('success', 'Pesan berhasil dihapus!');
    }
}
