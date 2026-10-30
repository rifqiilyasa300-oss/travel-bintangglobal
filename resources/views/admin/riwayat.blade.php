<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Transaksi - Bintang Global</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        .detail-item p {
            margin: 0; font-size: 11px; color: #2C4E58;
            font-weight: 800; text-transform: uppercase;
        }

        .footer-section {
            border-top: 1px solid #F1F5F9;
            padding-top: 25px;
            margin-top: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .price-label { font-size: 10px; color: #94A3B8; font-weight: 700; text-transform: uppercase; }
        .price-value { font-size: 26px; font-weight: 800; color: #166534; margin: 4px 0 10px 0; }

        .btn-action {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 16px; border-radius: 18px; text-decoration: none;
            font-weight: 800; font-size: 11px; text-transform: uppercase;
            transition: 0.3s; border: none; cursor: pointer; width: 100%;
            box-sizing: border-box;
        }

        .btn-validasi { background: #C5A367; color: white; }
        .btn-cek { background: #2C4E58; color: white; }
        .btn-jamaah { background: #E2E8F0; color: #2C4E58; }

        .btn-action:hover { opacity: 0.9; transform: translateY(-2px); }
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
                <div class="card">
                    <div class="group-name">Group: {{ $b->nama_group ?? 'Umum' }}</div>
                    <div class="package-title">{{ $b->package->nama_paket }}</div>

                    <div class="detail-grid">
                        <div class="hotel-row">
                            <div class="detail-item">
                                <label>Hotel / Armada</label>
                                <p style="font-size: 12px;">{{ $b->nama_hotel }}</p>
                            </div>
                        </div>

                        <div class="info-row">
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
                        <div>
                            <div class="price-label">Total Tagihan</div>
                            <div class="price-value">Rp {{ number_format($b->total_tagihan, 0, ',', '.') }}</div>
                        </div>

                        {{-- CEK APAKAH YANG LOGIN ADMIN --}}
                        @if(Auth::user()->role == 'admin')
                            <button onclick="validaSiRiil({{ $b->id }}, '{{ $b->nama_group }}', {{ $b->jumlah_jamaah }})" class="btn-action btn-validasi">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                VALIDASI KEDATANGAN RIIL
                            </button>

                            <a href="{{ route('admin.verifikasi', ['search_id' => $b->id]) }}" class="btn-action btn-cek">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                CEK BUKTI & VERIFIKASI
                            </a>

                            <a href="{{ route('admin.booking.show', $b->id) }}" class="btn-action btn-jamaah">
                                LIHAT DATA JAMAAH
                            </a>

                        {{-- JIKA BUKAN ADMIN (BERARTI AGEN) --}}
                        @else
                            <a href="{{ route('booking.invoice', $b->id) }}" class="btn-action btn-cek">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 012-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 012 2v4a2 2 0 002 2z"></path></svg>
                                CETAK INVOICE
                            </a>

                            {{-- Jika data manifest belum diisi sebanyak pax, kasih tombol input --}}
                            @if($b->manifests_count < $b->jumlah_jamaah)
                                <a href="{{ route('manifest.create', $b->id) }}" class="btn-action btn-validasi">
                                    INPUT DATA JAMAAH
                                </a>
                            @else
                                <a href="{{ route('manifest.show', $b->id) }}" class="btn-action btn-jamaah">
                                    LIHAT DATA JAMAAH
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 100px; color: #94A3B8; font-weight: 700;">
                    Belum ada transaksi yang tercatat.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Form tersembunyi untuk proses validasi (Hanya untuk Admin) --}}
    @if(Auth::user()->role == 'admin')
    <form id="formRevisi" action="{{ route('admin.validate.jamaah') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="transaction_id" id="rev_id">
        <input type="hidden" name="real_count" id="rev_count">
    </form>

    <script>
        function validaSiRiil(id, group, current) {
            Swal.fire({
                title: 'Validasi Data Riil',
                text: `Grup ${group}: Masukkan jumlah jamaah/pax yang benar-benar tiba di lokasi.`,
                input: 'number',
                inputAttributes: { min: 1 },
                inputValue: current,
                showCancelButton: true,
                confirmButtonText: 'REVISI TAGIHAN',
                confirmButtonColor: '#C5A367',
                cancelButtonColor: '#2C4E58'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('rev_id').value = id;
                    document.getElementById('rev_count').value = result.value;
                    document.getElementById('formRevisi').submit();
                }
            });
        }
    </script>
    @endif
</body>
</html>
