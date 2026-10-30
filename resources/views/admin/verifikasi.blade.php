<x-app-layout>
    {{-- CSS tambahan untuk layout dan responsivitas --}}
    <style>
        .max-w-7xl { max-width: none !important; }
        .container { max-width: none !important; width: 100% !important; }
        table { table-layout: fixed; width: 100%; }
        td { word-wrap: break-word; }

        .btn-kwitansi:hover { background-color: #b08d55 !important; transform: translateY(-2px); }
        .btn-verify:hover { opacity: 0.9; transform: scale(1.02); }

        /* Modal Background Fix */
        .modal-backdrop { opacity: 0.5 !important; }

        /* Custom Scrollbar untuk Modal Riwayat */
        .modal-body { max-height: 70vh; overflow-y: auto; }
    </style>

    {{-- Import Bootstrap JS untuk Modal --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div style="background-color: #F9F7F2; min-height: 100vh; padding: 2rem 0; font-family: 'Inter', sans-serif; width: 100%;">
        <div style="width: 98%; margin: 0 auto;">

            {{-- JUDUL HALAMAN --}}
            <div style="text-align: center; margin-bottom: 1.5rem;">
                <h2 style="font-size: 2.2rem; font-weight: 900; color: #2C4E58; text-transform: uppercase; letter-spacing: 0.1em;">
                    VERIFIKASI <span style="color: #C5A367;">PEMBAYARAN</span>
                </h2>
                <div style="width: 80px; height: 5px; background-color: #C5A367; margin: 10px auto; border-radius: 10px;"></div>
            </div>

            {{-- NAVIGASI --}}
            <div style="text-align: center; margin-bottom: 2.5rem;">
                <a href="{{ route('admin.verifikasi') }}" class="btn" style="border: 1.5px solid #C5A367; border-radius: 50px; color: #C5A367; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; background: transparent;">
                    ← REFRESH DATA
                </a>
            </div>

            {{-- TABEL UTAMA --}}
            <div style="background: white; border-radius: 3rem; box-shadow: 0 20px 50px rgba(44,78,88,0.1); overflow: hidden; border: 1px solid rgba(44,78,88,0.05); width: 100%;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #2C4E58;">
                            <th style="padding: 2rem 3rem; color: white; font-size: 12px; font-weight: 900; text-transform: uppercase; text-align: left; width: 30%;">Informasi Agen & Paket</th>
                            <th style="padding: 2rem; color: white; font-size: 12px; font-weight: 900; text-transform: uppercase; text-align: center; width: 25%;">Total Tagihan / Terbayar</th>
                            <th style="padding: 2rem; color: white; font-size: 12px; font-weight: 900; text-transform: uppercase; text-align: center; width: 20%;">Riwayat Bukti</th>
                            <th style="padding: 2rem 3rem; color: white; font-size: 12px; font-weight: 900; text-transform: uppercase; text-align: center; width: 25%;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $b)
                        @php
                            $total = $b->total_tagihan;
                            $terbayar = $b->payments->where('status', 'success')->sum('amount_paid');
                            $sisa = $total - $terbayar;
                            $st = strtoupper($b->status);
                        @endphp
                        <tr style="border-bottom: 1px solid #F1F5F9;">
                            {{-- KOLOM 1: INFO AGEN --}}
                            <td style="padding: 2.5rem 3rem;">
                                <div style="font-weight: 800; color: #2C4E58; font-size: 1.5rem; text-transform: uppercase;">
                                    {{ $b->user->name }}
                                </div>
                                <div style="font-size: 12px; color: #C5A367; font-weight: 700; margin-top: 6px; text-transform: uppercase;">
                                    {{ $b->package->nama_paket }}
                                    <span style="color: #cbd5e1; margin: 0 10px;">|</span>
                                    <span style="color: #94a3b8;">{{ $b->jumlah_jamaah }} PAX</span>
                                </div>
                            </td>

                            {{-- KOLOM 2: TOTAL & TERBAYAR --}}
                            <td style="padding: 2.5rem; text-align: center;">
                                <div style="color: #2C4E58; font-size: 1.5rem; font-weight: 900;">
                                    {{ $b->package->currency }} {{ number_format($total, 0, ',', '.') }}
                                </div>
                                <div style="font-size: 11px; font-weight: 800; color: #166534; margin-top: 5px; background: #DCFCE7; display: inline-block; padding: 4px 12px; border-radius: 6px;">
                                    TERBAYAR: {{ number_format($terbayar, 0, ',', '.') }}
                                </div>
                                @if($sisa > 0)
                                <div style="font-size: 11px; font-weight: 800; color: #DC2626; display: block; margin-top: 5px;">
                                    SISA: {{ number_format($sisa, 0, ',', '.') }}
                                </div>
                                @endif
                            </td>

                            {{-- KOLOM 3: BUKTI BAYAR --}}
                            <td style="padding: 2.5rem; text-align: center;">
                                <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modalBukti{{ $b->id }}" style="background: #F8FAFC; border: 2px dashed #C5A367; color: #2C4E58; font-weight: 800; font-size: 11px;">
                                    🖼️ CEK {{ $b->payments->count() }} BUKTI
                                </button>
                            </td>

                            {{-- KOLOM 4: TINDAKAN --}}
                            <td style="padding: 2.5rem 3rem; text-align: center;">
                                <div style="display: flex; flex-direction: column; gap: 8px; align-items: center; width: 100%;">

                                    @if($st == 'LUNAS')
                                        <div style="background: #DCFCE7; color: #166534; font-size: 11px; font-weight: 900; padding: 12px; border-radius: 10px; width: 100%; border: 1px solid #BBF7D0;">
                                            ✅ TERVERIFIKASI LUNAS
                                        </div>
                                    @elseif($st == 'DP')
                                        <div style="background: #E0F2FE; color: #0369A1; font-size: 11px; font-weight: 900; padding: 12px; border-radius: 10px; width: 100%; border: 1px solid #BAE6FD;">
                                            💳 TERVERIFIKASI DP
                                        </div>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalPelunasan{{ $b->id }}" style="width: 100%; background: #166534; color: white; border: none; padding: 10px; border-radius: 10px; font-weight: 800; font-size: 10px; cursor: pointer;">
                                            UPGRADE KE LUNAS
                                        </button>
                                    @else
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalPelunasan{{ $b->id }}" style="width: 100%; background: #E67E22; color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 800; font-size: 11px; cursor: pointer;">
                                            VERIFIKASI AWAL
                                        </button>
                                    @endif

                                    <a href="{{ route('admin.kwitansi', $b->id) }}" target="_blank" style="width: 100%; text-decoration: none;">
                                        <button type="button" class="btn-kwitansi" style="width: 100%; background: #C5A367; color: white; border: none; padding: 10px; border-radius: 10px; font-weight: 800; font-size: 11px; cursor: pointer;">
                                            🖨️ CETAK KWITANSI
                                        </button>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        {{-- MODAL RIWAYAT PEMBAYARAN (REVISI) --}}
                        <div class="modal fade" id="modalBukti{{ $b->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content" style="border-radius: 20px;">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="font-weight: 800; color: #2C4E58;">Riwayat Pembayaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        @foreach($b->payments as $pay)
                                            <div class="mb-3 p-3" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span style="font-weight: 800; font-size: 13px; color: #64748b;">📅 {{ $pay->created_at->format('d M Y') }}</span>
                                                    <span class="badge bg-success" style="font-size: 10px;">SUCCESS</span>
                                                </div>
                                                <p class="mb-2" style="font-weight: 900; color: #166534; font-size: 16px;">
                                                    {{ $b->package->currency }} {{ number_format($pay->amount_paid, 0, ',', '.') }}
                                                </p>

                                                {{-- LOGIKA CEK STRUK --}}
                                                @if($pay->proof_of_payment)
                                                    <a href="{{ asset('storage/bukti_bayar/' . $pay->proof_of_payment) }}" target="_blank" class="btn btn-primary w-100" style="font-size: 11px; font-weight: 700; border-radius: 8px;">
                                                        🖼️ LIHAT STRUK
                                                    </a>
                                                @else
                                                    <div style="background: #FEF3C7; color: #D97706; padding: 10px; border-radius: 8px; font-size: 11px; text-align: center; font-weight: 700; border: 1px solid #FDE68A;">
                                                        💵 PEMBAYARAN TUNAI (TANPA STRUK)
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MODAL INPUT PEMBAYARAN / UPGRADE --}}
                        <div class="modal fade" id="modalPelunasan{{ $b->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.storePayment', $b->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content" style="border-radius: 20px;">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="font-weight: 800;">Input Data Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: 700; font-size: 13px;">Nominal Pembayaran ({{ $b->package->currency }})</label>
                                                <input type="number" name="nominal" class="form-control" value="{{ $sisa }}" required style="border-radius: 10px;">
                                                <small class="text-muted">Default adalah sisa tagihan</small>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: 700; font-size: 13px;">Metode Bayar</label>
                                                <select name="metode_bayar" class="form-control" style="border-radius: 10px;">
                                                    <option value="TRANSFER">TRANSFER BANK</option>
                                                    <option value="CASH">TUNAI / CASH</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" style="font-weight: 700; font-size: 13px;">Upload Bukti Struk (Jika Ada)</label>
                                                <input type="file" name="bukti_bayar" class="form-control" style="border-radius: 10px;">
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-success w-100" style="padding: 12px; border-radius: 12px; font-weight: 800;">💾 SIMPAN & VERIFIKASI SEKARANG</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="4" style="padding: 10rem; text-align: center; color: #94a3b8; font-weight: 800;">TIDAK ADA ANTRIAN PEMBAYARAN</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
