<x-app-layout>
    <div style="background-color: #F9F7F2; min-height: 100vh; padding: 3rem 0;">
        <div class="max-w-xl mx-auto px-4">
            <div style="background-color: #ffffff; border-radius: 2rem; border-top: 10px solid #2C4E58; box-shadow: 0 20px 40px rgba(0,0,0,0.1); padding: 2rem;">

                <h2 style="text-align: center; font-weight: 900; color: #2C4E58; text-transform: uppercase; margin-bottom: 0.5rem;">Pilih Pembayaran</h2>

                {{-- TAMPILAN ERROR (PENTING: Agar tahu kenapa gagal upload) --}}
                @if ($errors->any())
                    <div style="background-color: #FEE2E2; color: #B91C1C; padding: 1rem; border-radius: 1rem; margin-bottom: 1.5rem; font-size: 0.8rem;">
                        <ul style="margin: 0; padding-left: 1rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div style="text-align: center; margin-bottom: 2rem; padding: 1rem; background-color: #FDFBF7; border-radius: 1rem; border: 1px solid #E5E7EB;">
                    <p style="font-size: 0.65rem; font-weight: 800; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 5px;">Total Yang Harus Dibayar</p>
                    <h1 style="font-size: 2rem; font-weight: 900; color: #2C4E58; margin: 0;">
                        Rp {{ number_format($booking->total_tagihan, 0, ',', '.') }}
                    </h1>
                </div>

                <form action="{{ route('booking.pay.process', $booking->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- 2. PILIHAN BANK --}}
                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; border: 2px solid #E5E7EB; border-radius: 1rem; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-weight: 900; color: #2C4E58;">BANK BSI</span>
                            </div>
                            <input type="radio" name="payment_method" value="BSI" onclick="showNorek('7236537999', 'BANK BSI')" required>
                        </label>

                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; border: 2px solid #E5E7EB; border-radius: 1rem; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-weight: 900; color: #2C4E58;">BANK BNI</span>
                            </div>
                            <input type="radio" name="payment_method" value="BNI" onclick="showNorek('1929941719', 'BANK BNI')">
                        </label>

                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; border: 2px solid #E5E7EB; border-radius: 1rem; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-weight: 900; color: #2C4E58;">BANK BRI</span>
                            </div>
                            <input type="radio" name="payment_method" value="BRI" onclick="showNorek('173901000308305', 'BANK BRI')">
                        </label>

                        <label style="display: flex; align-items: center; justify-content: space-between; padding: 1rem; border: 2px solid #166534; background-color: #F0FDF4; border-radius: 1rem; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span style="font-weight: 900; color: #166534;">TUNAI / CASH (KE KANTOR)</span>
                            </div>
                            <input type="radio" name="payment_method" value="TUNAI" onclick="showNorek('CASH', 'TUNAI')">
                        </label>
                    </div>

                    {{-- 3. KOTAK NOMOR REKENING --}}
                    <div id="box-norek" style="display: none; background-color: #2C4E58; color: white; padding: 1.5rem; border-radius: 1rem; margin-bottom: 2rem; text-align: center;">
                        <p style="font-size: 0.7rem; color: #C5A367; font-weight: 800; text-transform: uppercase;">Transfer Ke:</p>
                        <h3 id="nama-bank" style="font-weight: 900; margin-top: 5px;"></h3>
                        <div id="nomor-rekening" style="font-size: 1.5rem; font-weight: 900; letter-spacing: 2px; margin: 10px 0;"></div>
                        <p style="font-size: 0.7rem; opacity: 0.7;">a.n PT BINTANG GLOBAL GRUP</p>
                    </div>

                    {{-- 4. INPUT UPLOAD --}}
                    <div id="box-upload" style="display: none; margin-bottom: 2rem;">
                        <label style="display: block; font-size: 0.75rem; font-weight: 900; color: #2C4E58; text-transform: uppercase; margin-bottom: 0.5rem;">Upload Bukti Transfer:</label>
                        <input type="file" name="bukti_bayar" id="input-file" style="width: 100%; border: 2px dashed #C5A367; padding: 1rem; border-radius: 1rem;">
                    </div>

                    <button type="submit" style="width: 100%; background-color: #C5A367; color: white; padding: 1.25rem; border-radius: 1rem; font-weight: 900; text-transform: uppercase; border: none; cursor: pointer;">
                        Konfirmasi Pembayaran
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script>
        function showNorek(norek, bank) {
            const boxNorek = document.getElementById('box-norek');
            const boxUpload = document.getElementById('box-upload');
            const inputFile = document.getElementById('input-file');

            if (norek === 'CASH') {
                boxNorek.style.display = 'block';
                boxNorek.style.backgroundColor = '#166534';
                document.getElementById('nama-bank').innerText = 'SETOR TUNAI';
                document.getElementById('nomor-rekening').innerText = 'SILAKAN KE KASIR';
                boxUpload.style.display = 'none';
                inputFile.required = false;
            } else {
                boxNorek.style.display = 'block';
                boxNorek.style.backgroundColor = '#2C4E58';
                document.getElementById('nama-bank').innerText = bank;
                document.getElementById('nomor-rekening').innerText = norek;
                boxUpload.style.display = 'block';
                inputFile.required = true;
            }
        }
    </script>
</x-app-layout>
