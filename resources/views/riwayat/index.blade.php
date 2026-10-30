<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Transaksi - Bintang Global</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body { background-color: #FDFBF7; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; padding: 0; color: #1A363E; }
        .container { max-width: 1200px; margin: 0 auto; padding: 60px 20px; }
        .header { text-align: center; margin-bottom: 60px; }
        .title { font-size: 42px; font-weight: 800; color: #2C4E58; margin: 0; letter-spacing: -1px; }
        .subtitle { color: #C5A367; font-weight: 700; text-transform: uppercase; letter-spacing: 3px; font-size: 12px; margin-top: 10px; }
        .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 35px; }
        .card {
            background: #ffffff; border-radius: 35px;
            box-shadow: 0 20px 50px rgba(44, 78, 88, 0.12);
            border: 1px solid rgba(229, 231, 235, 0.5);
            padding: 35px; display: flex; flex-direction: column; position: relative; overflow: hidden;
        }
        .card::after {
            content: ''; position: absolute; right: 0; top: 0; bottom: 0;
            width: 8px; background: #C5A367; border-radius: 0 35px 35px 0;
        }
        .group-name { font-size: 11px; color: #C5A367; font-weight: 800; text-transform: uppercase; margin-bottom: 8px; }
        .package-title { font-size: 19px; font-weight: 800; color: #2C4E58; line-height: 1.3; margin-bottom: 25px; min-height: 50px; }
        .detail-grid {
            background: #F8FAFC; border-radius: 24px; padding: 22px;
            margin-bottom: 25px; border: 1px solid #EDF2F7;
        }
        .hotel-row { margin-bottom: 18px; border-bottom: 1px dashed #E2E8F0; padding-bottom: 12px; }
        .info-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; }
        .detail-item label {
            display: block; font-size: 8px; color: #94A3B8;
            font-weight: 800; text-transform: uppercase; margin-bottom: 5px;
            letter-spacing: 0.5px;
        }
        .detail-item p { margin: 0; font-size: 11px; color: #2C4E58; font-weight: 800; text-transform: uppercase; }
        .footer-section { border-top: 1px solid #F1F5F9; padding-top: 25px; margin-top: auto; }
        .price-label { font-size: 10px; color: #94A3B8; font-weight: 700; text-transform: uppercase; }
        .price-value { font-size: 26px; font-weight: 800; color: #166534; margin: 4px 0 20px 0; }
        .btn-invoice {
            background: #2C4E58; color: white; text-align: center; padding: 16px; border-radius: 18px;
            text-decoration: none; font-weight: 700; font-size: 13px; display: flex; align-items: center;
            justify-content: center; gap: 8px; transition: 0.3s;
        }
        .btn-invoice:hover { background: #1A363E; transform: translateY(-2px); }
        .btn-pelunasan {
            background: #D97706; color: white; text-align: center; padding: 12px; border-radius: 15px;
            text-decoration: none; font-weight: 800; font-size: 10px; display: flex; align-items: center;
            justify-content: center; gap: 8px; transition: 0.3s; margin-top: 10px;
            text-transform: uppercase; letter-spacing: 1.5px; width: 100%; border: none; cursor: pointer;
        }
        .btn-isi-data {
            background: #C5A367; color: white; text-align: center; padding: 12px; border-radius: 15px;
            text-decoration: none; font-weight: 800; font-size: 10px; display: flex; align-items: center;
            justify-content: center; gap: 8px; transition: 0.3s; margin-top: 15px;
            text-transform: uppercase; letter-spacing: 1.5px;
        }
        .btn-lihat-data { background: #059669; }
        .verif-status-disabled {
            margin-top: 15px; text-align: center; background: #F1F5F9; color: #94A3B8;
            padding: 12px; border-radius: 15px; font-size: 10px; font-weight: 800;
            text-transform: uppercase; letter-spacing: 1.5px;
        }
        /* Modal Style */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); align-items: center; justify-content: center; }
        .modal-content { background: white; padding: 30px; border-radius: 25px; width: 90%; max-width: 400px; }
    </style>
</head>
<body>

    @include('layouts.navigation')

    <div class="container">
        <div class="header">
            <h1 class="title">Riwayat Transaksi</h1>
            <p class="subtitle">Bintang Global Wisata Religi</p>
        </div>

        <div class="card-grid">
            @forelse($bookings as $b)
                @php
                    // Menghitung Sisa Bayar
                    $total_dibayar = $b->payments->where('status', 'success')->sum('amount_paid');
                    $sisa = $b->total_tagihan - $total_dibayar;
                    $status_raw = strtoupper($b->status);
                @endphp

                <div class="card">
                    <div class="group-name">Group: {{ $b->nama_group ?? 'Umum' }}</div>
                    <div class="package-title">{{ $b->package->nama_paket }}</div>

                    <div class="detail-grid">
                        <div class="hotel-row">
                            <div class="detail-item">
                                <label>Hotel</label>
                                <p style="font-size: 12px;">{{ $b->nama_hotel }}</p>
                            </div>
                        </div>
                        <div class="info-row" style="margin-bottom: 15px;">
                            <div class="detail-item">
                                <label>Kamar</label>
                                <p>{{ $b->jenis_kamar }}</p>
                            </div>
                            <div class="detail-item">
                                <label>Jamaah</label>
                                <p>{{ $b->jumlah_jamaah }} Pax</p>
                            </div>
                            <div class="detail-item">
                                <label>Status</label>
                                <p style="color: #C5A367;">{{ $b->status }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="footer-section">
                        <div class="price-label">Total Tagihan</div>
                        <div class="price-value">Rp {{ number_format($b->total_tagihan, 0, ',', '.') }}</div>

                        <a href="{{ route('booking.invoice', $b->id) }}" class="btn-invoice">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                            Lihat Invoice
                        </a>

                        {{-- TOMBOL PELUNASAN (Hanya muncul jika ada sisa) --}}
                        @if($sisa > 0)
                            <button type="button" onclick="openModal('{{ $b->id }}', '{{ $sisa }}')" class="btn-pelunasan">
                                💳 Bayar Sisa Pelunasan
                            </button>
                        @endif

                        {{-- LOGIKA TOMBOL DATA JAMAAH (Bisa diisi jika DP/LUNAS) --}}
                        @if(in_array($status_raw, ['DP', 'LUNAS', 'PAID']))
                            @if($b->manifests_count > 0)
                                <a href="{{ route('manifest.show', $b->id) }}" class="btn-isi-data btn-lihat-data">
                                    Lihat Data Jamaah
                                </a>
                            @else
                                <a href="{{ route('manifest.create', $b->id) }}" class="btn-isi-data">
                                    Isi Data Jamaah
                                </a>
                            @endif
                        @else
                            <div class="verif-status-disabled">
                                ⏳ Menunggu Verifikasi Admin
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 100px; color: #94A3B8;">Belum ada transaksi.</div>
            @endforelse
        </div>
    </div>

    <div id="modalPelunasan" class="modal">
        <div class="modal-content">
            <h2 style="font-size: 18px; color: #2C4E58; margin-bottom: 20px;">Upload Bukti Pelunasan</h2>
            <form action="{{ route('pembayaran.pelunasan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="booking_id" id="modal_booking_id">

                <div style="margin-bottom: 15px;">
                    <label style="font-size: 10px; font-weight: bold; color: #94A3B8; display: block; margin-bottom: 5px;">NOMINAL SISA</label>
                    <input type="text" id="modal_sisa_text" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 10px; background: #F8FAFC;" readonly>
                    <input type="hidden" name="amount_paid" id="modal_amount_paid">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-size: 10px; font-weight: bold; color: #94A3B8; display: block; margin-bottom: 5px;">PILIH REKENING TUJUAN</label>
                    <select name="metode_bayar" style="width: 100%; padding: 10px; border: 1px solid #E2E8F0; border-radius: 10px;">
                        <option value="BSI">BSI (727 680 8202)</option>
                        <option value="BNI">BNI (1929941719)</option>
                        <option value="BRI">BRI (173901000308305)</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-size: 10px; font-weight: bold; color: #94A3B8; display: block; margin-bottom: 5px;">UPLOAD STRUK/BUKTI</label>
                    <input type="file" name="proof_of_payment" accept="image/*" required style="font-size: 12px;">
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="closeModal()" style="flex: 1; padding: 12px; border-radius: 15px; border: 1px solid #E2E8F0; background: white; cursor: pointer;">Batal</button>
                    <button type="submit" style="flex: 1; padding: 12px; border-radius: 15px; border: none; background: #2C4E58; color: white; font-weight: bold; cursor: pointer;">Kirim Bukti</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id, sisa) {
            document.getElementById('modal_booking_id').value = id;
            document.getElementById('modal_amount_paid').value = sisa;
            document.getElementById('modal_sisa_text').value = "Rp " + new Intl.NumberFormat('id-ID').format(sisa);
            document.getElementById('modalPelunasan').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('modalPelunasan').style.display = 'none';
        }
    </script>
</body>
</html>
