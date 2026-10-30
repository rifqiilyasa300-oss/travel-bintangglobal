<x-app-layout>
    <div style="background-color: #F9F7F2; min-height: 100vh; padding: 3rem 0;">
        <div class="max-w-3xl mx-auto px-4">

            <div style="background-color: #ffffff; border-radius: 2.5rem; border-top: 12px solid #2C4E58; box-shadow: 0 20px 50px rgba(44,78,88,0.15); overflow: hidden;">
                <div class="p-8 md:p-12 text-center">

                    <div style="background-color: #DCFCE7; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                        <svg style="width: 30px; height: 30px; color: #166534;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    <h1 style="color: #2C4E58; font-size: 1.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: -0.02em; margin-bottom: 0.5rem;">Pesanan Berhasil Dibuat!</h1>
                    <p style="color: #9CA3AF; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 2rem;">Silakan selesaikan pembayaran sesuai detail di bawah</p>

                    <div style="background-color: #F9FAFB; border-radius: 1.5rem; padding: 2rem; margin-bottom: 2rem; border: 2px dashed #E5E7EB;">
                        <span style="color: #2C4E58; font-size: 0.65rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.2em;">Total Tagihan</span>
                        <h2 style="color: #166534; font-size: 2.5rem; font-weight: 900; margin: 0.5rem 0;">Rp {{ number_format($booking->total_tagihan, 0, ',', '.') }}</h2>
                        <div style="color: #C5A367; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">ID BOOKING: #BGT-{{ $booking->id }}</div>
                    </div>

                    <div style="text-align: left; background-color: #2C4E58; border-radius: 1.5rem; padding: 2rem; color: #ffffff; position: relative; overflow: hidden;">
                        <div style="position: absolute; right: -20px; top: -20px; opacity: 0.1;">
                            <svg width="150" height="150" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                        </div>

                        <p style="font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; color: #C5A367; margin-bottom: 1rem;">Transfer Ke Rekening Resmi:</p>

                        {{-- Logika Nama Bank & Nomor Rekening --}}
                        @if($booking->metode_bayar == 'BCA')
                            <h3 style="font-size: 1.25rem; font-weight: 900; margin-bottom: 0.25rem;">BANK BCA</h3>
                            <div style="font-size: 1.75rem; font-weight: 900; letter-spacing: 0.05em; margin-bottom: 0.5rem;">028-123-4567</div>
                        @elseif($booking->metode_bayar == 'BSI')
                            <h3 style="font-size: 1.25rem; font-weight: 900; margin-bottom: 0.25rem;">BANK SYARIAH INDONESIA (BSI)</h3>
                            <div style="font-size: 1.75rem; font-weight: 900; letter-spacing: 0.05em; margin-bottom: 0.5rem;">711-888-9990</div>
                        @elseif($booking->metode_bayar == 'BRI')
                            <h3 style="font-size: 1.25rem; font-weight: 900; margin-bottom: 0.25rem;">BANK BRI</h3>
                            <div style="font-size: 1.75rem; font-weight: 900; letter-spacing: 0.05em; margin-bottom: 0.5rem;">0021-01-000-123</div>
                        @else
                            <h3 style="font-size: 1.25rem; font-weight: 900; margin-bottom: 0.25rem;">BANK MANDIRI</h3>
                            <div style="font-size: 1.75rem; font-weight: 900; letter-spacing: 0.05em; margin-bottom: 0.5rem;">123-456-7890</div>
                        @endif

                        <p style="font-size: 0.75rem; font-weight: 700; opacity: 0.8;">a.n PT BINTANG GLOBAL WISATA</p>
                    </div>

                    <div style="margin-top: 2rem;">
                        <p style="color: #6B7280; font-size: 0.75rem; font-weight: 600; line-height: 1.5; margin-bottom: 2rem;">
                            Setelah melakukan transfer, mohon simpan bukti pembayaran dan upload melalui halaman <b>Riwayat Transaksi</b> untuk diverifikasi oleh Admin.
                        </p>

                        <a href="{{ route('riwayat') }}"
                           style="display: inline-block; width: 100%; background-color: #C5A367; color: #ffffff; font-weight: 900; padding: 1.25rem; border-radius: 1rem; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.2em; text-decoration: none; transition: 0.3s;"
                           onmouseover="this.style.backgroundColor='#2C4E58'" onmouseout="this.style.backgroundColor='#C5A367'">
                            Lihat Riwayat & Upload Bukti
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
