<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi_{{ $booking->id }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; color: #333; margin: 0; padding: 20px; }
        .receipt-box { max-width: 800px; margin: auto; border: 2px solid #2C4E58; padding: 30px; position: relative; background: #fff; }

        /* Header */
        .header { text-align: center; border-bottom: 2px double #2C4E58; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #2C4E58; text-transform: uppercase; font-size: 24px; }
        .header p { margin: 5px 0; font-size: 11px; line-height: 1.4; }

        /* Info Section */
        .info-section { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-box p { margin: 5px 0; font-size: 14px; }

        /* Table */
        .content-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .content-table th { background: #2C4E58; color: white; padding: 12px; text-align: left; text-transform: uppercase; font-size: 13px; }
        .content-table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; }

        /* Total & Summary Section */
        .summary-box { margin-left: auto; width: 350px; margin-top: 10px; }
        .summary-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 14px; }
        .total-section {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            color: #2C4E58;
            margin-top: 10px;
            border-top: 2px solid #2C4E58;
            padding-top: 10px;
        }

        .terbilang-box { margin-top: 20px; padding: 10px; border: 1px dashed #ccc; background: #f9f9f9; font-style: italic; font-size: 13px; }

        /* Footer / Tanda Tangan */
        .footer { margin-top: 50px; display: flex; justify-content: space-between; text-align: center; }
        .signature { width: 250px; }
        .signature-space { height: 70px; }
        .signature-name { font-weight: bold; border-top: 1px solid #333; display: inline-block; padding-top: 5px; min-width: 180px; }

        /* Status Watermark */
        .watermark {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 100px; color: rgba(44, 78, 88, 0.08); pointer-events: none;
            text-transform: uppercase; font-weight: bold; letter-spacing: 10px;
        }

        @media print {
            .no-print { display: none; }
            body { padding: 0; background: none; }
            .receipt-box { border: 1px solid #ddd; padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 12px 25px; background: #2C4E58; color: white; border: none; cursor: pointer; border-radius: 5px; font-weight: bold;">
            🖨️ KLIK UNTUK CETAK KWITANSI
        </button>
        <p style="font-size: 11px; color: #666; margin-top: 5px;">Gunakan kertas A4 atau Letter</p>
    </div>

    <div class="receipt-box">
        <div class="watermark">{{ $booking->status }}</div>

        <div class="header">
            <h1>PT BINTANG GLOBAL WISATA</h1>
            <p>Jl. Raya Condet No.8a, RT.5/RW.3, Balekambang, Kec. Kramat jati, Jakarta Timur</p>
            <p>Telp: 0858-5058-1030 | Email: info@bintangglobal.com</p>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="text-decoration: underline; margin-bottom: 5px; color: #2C4E58;">KWITANSI PEMBAYARAN</h2>
            <p style="font-size: 12px; margin: 0;">No. Invoice: #INV/{{ date('Ymd') }}/{{ $booking->id }}</p>
        </div>

        <div class="info-section">
            <div class="info-box">
                <p><strong>Diterima Dari:</strong></p>
                <p style="font-size: 16px;">{{ $booking->user->name }}</p>
            </div>
            <div class="info-box" style="text-align: right;">
                <p><strong>Tanggal:</strong></p>
                <p>{{ $booking->updated_at->format('d F Y') }}</p>
            </div>
        </div>

        <table class="content-table">
            <thead>
                <tr>
                    <th>Deskripsi Layanan</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                {{-- Tampilkan Semua Detail dari tabel booking_details --}}
                @foreach($booking->details as $detail)
                <tr>
                    <td>
                        <strong>{{ $detail->nama_layanan }}</strong><br>
                        <small style="color: #666;">{{ $detail->keterangan }}</small>
                    </td>
                    <td style="text-align: center;">{{ $detail->qty }} PAX</td>
                    <td style="text-align: right;">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ number_format($detail->qty * $detail->harga, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @php
            $totalDibayar = $booking->payments()->where('status', 'SUCCESS')->sum('amount_paid');
            $sisaTagihan = $booking->total_tagihan - $totalDibayar;
        @endphp

        <div class="summary-box">
            <div class="summary-row">
                <span>Grand Total:</span>
                <span>{{ $booking->package->currency }} {{ number_format($booking->total_tagihan, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row" style="color: green;">
                <span>Total Telah Dibayar:</span>
                <span>{{ $booking->package->currency }} {{ number_format($totalDibayar, 0, ',', '.') }}</span>
            </div>
            @if($sisaTagihan > 0)
            <div class="summary-row" style="color: red; font-weight: bold;">
                <span>Sisa Kekurangan:</span>
                <span>{{ $booking->package->currency }} {{ number_format($sisaTagihan, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="total-section">
                TOTAL TAGIHAN: {{ $booking->package->currency }} {{ number_format($booking->total_tagihan, 0, ',', '.') }}
            </div>
        </div>

        <div class="terbilang-box">
            <strong>Terbilang:</strong> # {{ $terbilang }} #
        </div>

        <div class="footer">
            <div class="signature">
                <p>Agen/Penyetor</p>
                <div class="signature-space"></div>
                <div class="signature-name">( {{ $booking->user->name }} )</div>
            </div>

            <div class="signature">
                <p>Admin</p>
                <div class="signature-space"></div>
                <div class="signature-name">( {{ $nama_admin }} )</div>
            </div>
        </div>

        <div style="margin-top: 40px; font-size: 10px; color: #888; text-align: center; border-top: 1px solid #eee; padding-top: 10px;">
            Kwitansi ini adalah bukti pembayaran yang sah dan dihasilkan secara komputerisasi.
        </div>
    </div>
</body>
</html>
