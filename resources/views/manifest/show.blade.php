<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview Manifest - Bintang Global</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary-navy: #1e293b;
            --accent-gold: #c5a367;
            --bg-light: #f1f5f9;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #334155;
            margin: 0;
            padding: 40px 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 0;
            border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header-section {
            background-color: var(--primary-navy);
            color: white;
            padding: 50px 20px;
            text-align: center;
            position: relative;
        }

        .header-section h2 {
            margin: 0;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #ffffff;
        }

        .header-section p {
            color: #94a3b8;
            margin-top: 10px;
            font-size: 16px;
            font-weight: 600;
        }

        .badge-group {
            display: inline-block;
            background: var(--accent-gold);
            color: white;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            margin-top: 15px;
        }

        .content-body { padding: 40px; }

        /* TABEL STYLING */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 20px;
        }

        table { width: 100%; border-collapse: collapse; }

        th {
            background: #f8fafc;
            text-align: left;
            padding: 18px 15px;
            color: var(--primary-navy);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 20px 15px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #1e293b;
            font-weight: 600;
        }

        tr:hover td { background-color: #f8fafc; }

        .img-pasfoto {
            width: 50px; height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-gold);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .img-paspor {
            width: 70px; height: 45px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
        }

        .jk-badge {
            font-size: 10px; font-weight: 800;
            padding: 4px 10px; border-radius: 6px;
        }
        .jk-l { background: #dcfce7; color: #15803d; }
        .jk-p { background: #fef2f2; color: #b91c1c; }

        /* TOMBOL TAMBAH JAMAAH */
        .add- jamaah-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .btn-add {
            background: var(--accent-gold);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 800;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
            box-shadow: 0 4px 14px 0 rgba(197, 163, 103, 0.39);
        }
        .btn-add:hover {
            transform: translateY(-2px);
            background: #b38f56;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 8px 16px;
            border: 1.5px solid var(--accent-gold);
            color: var(--accent-gold);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 700;
            font-size: 12px;
            transition: 0.2s;
        }
        .btn-edit:hover {
            background: var(--accent-gold);
            color: white;
        }

        .btn-back-container { margin-top: 40px; text-align: center; }
        .btn-back {
            background: var(--primary-navy);
            color: white;
            padding: 15px 35px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 800;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }
        .btn-back:hover { background: #0f172a; transform: translateY(-2px); }

    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <h2>Preview Data Manifest Jamaah</h2>
        <p>Paket: {{ $booking->package->nama_paket }}</p>
        <div class="badge-group">Group: {{ $booking->nama_group }} ({{ $booking->jumlah_jamaah }} PAX)</div>
    </div>

    <div class="content-body">
        @if (session('success'))
            <div style="background: #dcfce7; color: #15803d; padding: 15px; border-radius: 12px; margin-bottom: 25px; font-size: 14px; font-weight: 700;">
                ✓ {{ session('success') }}
            </div>
        @endif

        <div class="add-jamaah-wrapper">
            <div style="color: #64748b; font-size: 14px; font-weight: 600;">
                Terisi: <span style="color: var(--primary-navy);">{{ $booking->manifests->count() }}</span> / {{ $booking->jumlah_jamaah }} Jamaah
            </div>

            {{-- TOMBOL TAMBAH AKAN MUNCUL JIKA DATA BELUM LENGKAP --}}
            @if($booking->manifests->count() < $booking->jumlah_jamaah)
                <a href="{{ route('manifest.create', $booking->id) }}" class="btn-add">
                    + Tambah Jamaah Baru
                </a>
            @endif
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jamaah</th>
                        <th>Gender</th>
                        <th>No. Paspor</th>
                        <th>Kamar</th>
                        <th>Scan Paspor</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($booking->manifests as $index => $m)
                    <tr>
                        <td style="color: #94a3b8;">{{ $index + 1 }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 15px;">
                                @if($m->pasfoto)
                                    <img src="{{ asset('storage/' . $m->pasfoto) }}" class="img-pasfoto">
                                @else
                                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 20px;">👤</div>
                                @endif
                                <div>
                                    <div style="font-weight: 800; color: var(--primary-navy);">{{ $m->nama_lengkap }}</div>
                                    <div style="font-size: 11px; color: #94a3b8;">ID: {{ $m->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="jk-badge {{ $m->jenis_kelamin == 'L' ? 'jk-l' : 'jk-p' }}">
                                {{ $m->jenis_kelamin == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN' }}
                            </span>
                        </td>
                        <td style="font-family: monospace; font-size: 15px;">{{ $m->nomor_paspor }}</td>
                        <td>
                            <span style="color: var(--accent-gold);">{{ $m->grup_kamar }}</span>
                            <span style="font-size: 11px; color: #94a3b8;">({{ $m->tipe_kamar }})</span>
                        </td>
                        <td>
                            @if($m->foto_paspor)
                                <a href="{{ asset('storage/' . $m->foto_paspor) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $m->foto_paspor) }}" class="img-paspor">
                                </a>
                            @else
                                <span style="font-size: 11px; color: #cbd5e1;">Kosong</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <a href="{{ route('manifest.edit', $m->id) }}" class="btn-edit">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="btn-back-container">
            <a href="{{ route('riwayat') }}" class="btn-back">
                ← SELESAI & KEMBALI KE RIWAYAT
            </a>
        </div>
    </div>
</div>

</body>
</html>
