<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manifest_{{ $booking->nama_group }}_{{ date('Ymd') }}</title>
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --primary-navy: #1e293b;
            --accent-gold: #c5a367;
            --bg-light: #f1f5f9;
            --success-green: #166534;
        }

        body { background-color: var(--bg-light); font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 40px 20px; }

        .container {
            max-width: 1100px; margin: 0 auto; background: white; border-radius: 24px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden;
        }

        .header-section {
            background-color: var(--primary-navy); color: white; padding: 40px 20px;
            text-align: center; position: relative;
        }

        .header-section h2 { margin: 0; font-size: 28px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }

        .badge-group {
            display: inline-block; background: var(--accent-gold); color: white;
            padding: 5px 15px; border-radius: 30px; font-size: 11px; font-weight: 800; margin-top: 10px;
        }

        .content-body { padding: 40px; }

        /* Style Baru: Info Ringkasan Validasi */
        .summary-box {
            display: grid; grid-template-columns: 1fr 1fr; gap: 20px;
            margin-bottom: 30px; background: #f8fafc; padding: 25px;
            border-radius: 20px; border: 1px solid #e2e8f0;
        }

        .summary-item label { display: block; font-size: 10px; color: #64748b; font-weight: 800; text-transform: uppercase; margin-bottom: 5px; }
        .summary-item p { margin: 0; font-size: 18px; font-weight: 800; color: var(--primary-navy); }

        .status-badge {
            display: inline-block; padding: 6px 12px; border-radius: 8px;
            font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 20px;
        }
        .status-valid { background: #dcfce7; color: #166534; }
        .status-revisi { background: #fee2e2; color: #991b1b; }

        /* Table Design */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th {
            background: #f8fafc; text-align: left; padding: 15px; color: var(--primary-navy);
            font-size: 10px; font-weight: 800; text-transform: uppercase; border-bottom: 2px solid var(--accent-gold);
        }
        td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #1e293b; font-weight: 600; }

        .img-pasfoto { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-gold); }
        .img-paspor { width: 60px; height: 40px; border-radius: 4px; object-fit: cover; }

        .no-print-area { margin-top: 30px; display: flex; justify-content: center; gap: 15px; }
        .btn {
            padding: 12px 25px; border-radius: 10px; text-decoration: none; font-weight: 800;
            font-size: 13px; cursor: pointer; border: none; transition: 0.3s;
        }
        .btn-print { background: var(--accent-gold); color: white; }
        .btn-back { background: var(--primary-navy); color: white; }

        @media print {
            body { background: white; padding: 0; }
            .container { box-shadow: none; max-width: 100%; border-radius: 0; border: none; }
            .no-print-area { display: none !important; }
            .header-section { background: white !important; color: black !important; border-bottom: 3px solid var(--primary-navy); }
            .header-section h2 { color: black !important; font-size: 22px; }
            .badge-group { border: 1px solid black; color: black !important; background: transparent !important; }
            .summary-box { border: 1px solid #ccc !important; background: transparent !important; }
            th { background: #eee !important; color: black !important; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header-section">
        <div style="font-size: 12px; font-weight: 700; color: var(--accent-gold); margin-bottom: 5px;">BINTANG GLOBAL TOUR & TRAVEL</div>
        <h2>Manifest Report: {{ $booking->package->nama_paket }}</h2>
        <p style="margin: 5px 0; font-size: 14px; color: #94a3b8;">ID Booking: #{{ $booking->id }} | Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
        <div class="badge-group">Group: {{ $booking->nama_group }}</div>
    </div>

    <div class="content-body">

        @if($booking->jumlah_jamaah != $booking->manifests->count())
            <div class="status-badge status-revisi">
                ⚠️ PERHATIAN: DATA MANIFEST ({{ $booking->manifests->count() }} ORANG) BERBEDA DENGAN TAGIHAN RIIL ({{ $booking->jumlah_jamaah }} PAX)
            </div>
        @else
            <div class="status-badge status-valid">
                ✅ DATA MANIFEST DAN TAGIHAN SINKRON ({{ $booking->jumlah_jamaah }} PAX)
            </div>
        @endif

        <div class="summary-box">
            <div class="summary-item">
                <label>Total Tagihan Akhir</label>
                <p style="color: var(--success-green);">Rp {{ number_format($booking->total_tagihan, 0, ',', '.') }}</p>
            </div>
            <div class="summary-item" style="text-align: right;">
                <label>Jumlah Kedatangan Riil</label>
                <p>{{ $booking->jumlah_jamaah }} Pax</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>L/P</th>
                    <th>No. Paspor</th>
                    <th>Kamar</th>
                    <th>Pasfoto</th>
                    <th>Scan Paspor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($booking->manifests as $index => $m)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><div style="font-weight: 800;">{{ strtoupper($m->nama_lengkap) }}</div></td>
                    <td>{{ $m->jenis_kelamin }}</td>
                    <td style="font-family: monospace;">{{ $m->nomor_paspor }}</td>
                    <td>{{ $m->grup_kamar }} ({{ $m->tipe_kamar }})</td>
                    <td>
                        @if($m->pasfoto)
                            <img src="{{ asset('storage/' . $m->pasfoto) }}" class="img-pasfoto">
                        @else
                            <div style="font-size: 10px; color: #ccc;">N/A</div>
                        @endif
                    </td>
                    <td>
                        @if($m->foto_paspor)
                            <img src="{{ asset('storage/' . $m->foto_paspor) }}" class="img-paspor">
                        @else
                            <div style="font-size: 10px; color: #ccc;">N/A</div>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="no-print-area">
            <a href="{{ route('admin.riwayat') }}" class="btn btn-back">← KEMBALI</a>
            <button onclick="window.print()" class="btn btn-print">🖨️ CETAK MANIFEST SEKARANG</button>
        </div>
    </div>
</div>

</body>
</html>
