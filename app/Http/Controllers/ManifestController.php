<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manifest;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;

class ManifestController extends Controller
{
    public function create($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        // Hitung berapa jamaah yang SUDAH terdaftar
        $sudah_isi = $booking->manifests()->count();

        // Hitung berapa SISA yang harus diisi
        $sisa_kuota = $booking->jumlah_jamaah - $sudah_isi;

        // Jika kuota sudah penuh, tendang balik ke preview
        if ($sisa_kuota <= 0) {
            return redirect()->route('manifest.show', $booking_id)
                             ->with('info', 'Data jamaah sudah lengkap sesuai kuota.');
        }

        return view('manifest.create', compact('booking', 'sudah_isi', 'sisa_kuota'));
    }

    public function store(Request $request, $booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        // Validasi input sebagai array (menggunakan .*)
        $request->validate([
            'nama_lengkap.*'  => 'required|string|max:255',
            'nomor_paspor.*'  => 'required|string|max:20',
            'jenis_kelamin.*' => 'required|in:L,P',
            'grup_kamar.*'    => 'required',
            'tipe_kamar.*'    => 'required',
            'foto_paspor.*'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'pasfoto.*'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Looping berdasarkan jumlah input nama yang dikirim
        foreach ($request->nama_lengkap as $index => $nama) {
            $data = [
                'booking_id'    => $booking_id,
                'nama_lengkap'  => $nama,
                'nomor_paspor'  => $request->nomor_paspor[$index],
                'jenis_kelamin' => $request->jenis_kelamin[$index],
                'grup_kamar'    => $request->grup_kamar[$index],
                'tipe_kamar'    => $request->tipe_kamar[$index],
            ];

            // Proses upload Foto Paspor (Array File)
            if ($request->hasFile("foto_paspor.$index")) {
                $data['foto_paspor'] = $request->file("foto_paspor.$index")->store('manifests', 'public');
            }

            // Proses upload Pasfoto (Array File)
            if ($request->hasFile("pasfoto.$index")) {
                $data['pasfoto'] = $request->file("pasfoto.$index")->store('manifests', 'public');
            }

            Manifest::create($data);
        }

        return redirect()->route('manifest.show', $booking_id)
                         ->with('success', 'Berhasil menambahkan ' . count($request->nama_lengkap) . ' data jamaah sekaligus!');
    }

    public function show($booking_id)
    {
        $booking = Booking::with(['package', 'manifests'])->findOrFail($booking_id);
        $manifests = $booking->manifests;
        return view('manifest.show', compact('booking', 'manifests'));
    }

    public function edit($id)
    {
        $manifest = Manifest::findOrFail($id);
        return view('manifest.edit', compact('manifest'));
    }

    public function update(Request $request, $id)
    {
        $manifest = Manifest::findOrFail($id);
        // ... (Logika update tetap sama seperti sebelumnya karena edit dilakukan per orang) ...
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'nomor_paspor'  => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:L,P',
            'grup_kamar'    => 'required',
            'tipe_kamar'    => 'required',
            'foto_paspor'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'pasfoto'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except(['_token', '_method']);

        if ($request->hasFile('foto_paspor')) {
            if ($manifest->foto_paspor) { Storage::disk('public')->delete($manifest->foto_paspor); }
            $data['foto_paspor'] = $request->file('foto_paspor')->store('manifests', 'public');
        }

        if ($request->hasFile('pasfoto')) {
            if ($manifest->pasfoto) { Storage::disk('public')->delete($manifest->pasfoto); }
            $data['pasfoto'] = $request->file('pasfoto')->store('manifests', 'public');
        }

        $manifest->update($data);

        return redirect()->route('manifest.show', $manifest->booking_id)
                         ->with('success', 'Data berhasil diupdate!');
    }
}
