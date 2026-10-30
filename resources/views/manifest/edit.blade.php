<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Jamaah - Bintang Global</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body { background-color: #FDFBF7; font-family: 'Plus Jakarta Sans', sans-serif; color: #1A363E; padding: 40px; }
        .card { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 30px; box-shadow: 0 10px 30px rgba(44, 78, 88, 0.05); border: 1px solid #F1F5F9; }
        h2 { color: #2C4E58; margin-bottom: 30px; font-weight: 800; letter-spacing: -1px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 13px; color: #64748B; }
        input, select { width: 100%; padding: 12px; border: 1.5px solid #F1F5F9; border-radius: 12px; font-family: inherit; font-weight: 600; box-sizing: border-box; transition: 0.3s; }
        input:focus { outline: none; border-color: #C5A367; background-color: #FDFBF7; }

        /* Styling untuk Preview Gambar Kecil */
        .file-preview { display: flex; align-items: center; gap: 10px; margin-top: 5px; margin-bottom: 10px; padding: 10px; background: #F8FAFC; border-radius: 10px; border: 1px solid #F1F5F9; }
        .file-preview img { width: 40px; height: 40px; border-radius: 6px; object-fit: cover; border: 1px solid #E2E8F0; }
        .file-preview span { font-size: 11px; color: #94A3B8; font-weight: 600; }

        .btn-save { width: 100%; padding: 15px; background: #C5A367; color: white; border: none; border-radius: 15px; font-weight: 800; cursor: pointer; margin-top: 20px; transition: 0.3s; box-shadow: 0 10px 20px rgba(197, 163, 103, 0.2); }
        .btn-save:hover { background: #B49256; transform: translateY(-2px); }
        .btn-cancel { display: block; text-align: center; margin-top: 20px; color: #94A3B8; text-decoration: none; font-size: 13px; font-weight: 700; transition: 0.3s; }
        .btn-cancel:hover { color: #1A363E; }
    </style>
</head>
<body>

<div class="card">
    <h2>Edit Data Jamaah</h2>

    <form action="{{ route('manifest.update', $manifest->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ $manifest->nama_lengkap }}" required>
        </div>

        <div class="form-group">
            <label>Nomor Paspor</label>
            <input type="text" name="nomor_paspor" value="{{ $manifest->nomor_paspor }}" required>
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin">
                <option value="L" {{ $manifest->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $manifest->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="row" style="display: flex; gap: 15px;">
            <div class="form-group" style="flex: 1;">
                <label>Grup Kamar</label>
                <input type="text" name="grup_kamar" value="{{ $manifest->grup_kamar }}" required>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Tipe Kamar</label>
                <select name="tipe_kamar">
                    <option value="Double" {{ $manifest->tipe_kamar == 'Double' ? 'selected' : '' }}>Double</option>
                    <option value="Triple" {{ $manifest->tipe_kamar == 'Triple' ? 'selected' : '' }}>Triple</option>
                    <option value="Quad" {{ $manifest->tipe_kamar == 'Quad' ? 'selected' : '' }}>Quad</option>
                </select>
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #F1F5F9; margin: 25px 0;">

        <div class="form-group">
            <label>Update Scan Paspor</label>
            @if($manifest->foto_paspor)
                <div class="file-preview">
                    <img src="{{ asset('storage/' . $manifest->foto_paspor) }}" alt="Preview Paspor">
                    <span>File saat ini tersedia</span>
                </div>
            @endif
            <input type="file" name="foto_paspor" accept="image/*">
        </div>

        <div class="form-group">
            <label>Update Pasfoto (Wajah)</label>
            @if($manifest->pasfoto)
                <div class="file-preview">
                    <img src="{{ asset('storage/' . $manifest->pasfoto) }}" alt="Preview Pasfoto">
                    <span>File saat ini tersedia</span>
                </div>
            @endif
            <input type="file" name="pasfoto" accept="image/*">
        </div>

        <button type="submit" class="btn-save">Simpan Perubahan</button>
        <a href="{{ route('manifest.show', $manifest->booking_id) }}" class="btn-cancel">Batal & Kembali</a>
    </form>
</div>

</body>
</html>
