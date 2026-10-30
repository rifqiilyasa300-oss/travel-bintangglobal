<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .form-container {
            background-color: #ffffff;
            border-radius: 2.5rem;
            border-top: 15px solid #2C4E58;
            box-shadow: 0 30px 80px rgba(44,78,88,0.12);
        }

        .label-style {
            color: #000000;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 0.7rem;
            display: block;
            margin-left: 0.2rem;
        }

        .form-input {
            width: 100%;
            padding: 1.15rem 1.25rem;
            background-color: #F8FAFC;
            border: 2px solid #E2E8F0;
            border-radius: 1.25rem;
            color: #1F2937;
            font-weight: 700;
            transition: all 0.3s ease;
            outline: none;
            font-size: 0.95rem;
        }

        .form-input:focus {
            border-color: #C5A367;
            background-color: #ffffff;
            box-shadow: 0 10px 20px rgba(197, 163, 103, 0.08);
        }

        select.form-input {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23111827' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1.5em 1.5em;
        }

        .total-box {
            background: linear-gradient(135deg, #2C4E58 0%, #1a2e34 100%);
            padding: 2.25rem;
            border-radius: 2rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 3rem;
            border: 1px solid rgba(197, 163, 103, 0.2);
        }

        .btn-confirm {
            background-color: #C5A367;
            color: #ffffff;
            padding: 1.1rem 2.2rem;
            border-radius: 1.1rem;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.1em;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-confirm:hover {
            background-color: #000000;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .alert-error {
            background-color: #FFF1F2;
            border-left: 5px solid #F43F5E;
            padding: 1.25rem;
            border-radius: 1.25rem;
            margin-bottom: 2rem;
        }
    </style>

    <div style="background-color: #FDFBF7; min-height: 100vh; padding: 4rem 0;">
        <div class="max-w-4xl mx-auto px-4">

            @if ($errors->any())
                <div class="alert-error">
                    <h4 style="color: #9F1239; font-weight: 800; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 0.5rem;">Terjadi Kesalahan:</h4>
                    <ul style="color: #BE123C; font-size: 0.85rem; font-weight: 600; list-style: inside disc;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error" style="border-left-color: #F59E0B; background-color: #FFFBEB;">
                    <p style="color: #92400E; font-weight: 700; font-size: 0.85rem;">{{ session('error') }}</p>
                </div>
            @endif

            <div class="form-container overflow-hidden">
                <div class="p-8 md:p-14">

                    <div class="text-center mb-12">
                        <span style="color: #C5A367; font-weight: 800; font-size: 0.7rem; letter-spacing: 0.4em; text-transform: uppercase; display: block; margin-bottom: 0.5rem;">
                            Aman & Terverifikasi
                        </span>
                        <h1 style="color: #2C4E58; font-size: 2.5rem; font-weight: 900; letter-spacing: -0.04em; margin: 0;">
                            Konfirmasi <span style="color: #C5A367;">Reservasi</span>
                        </h1>
                        <p style="color: #94A3B8; font-size: 0.85rem; font-weight: 600; margin-top: 0.5rem;">
                            {{ $package->category == 'transport_only' ? 'Penyewaan Armada Bus & Transport' : 'Booking Layanan Hotel & Umroh' }}
                        </p>
                        <div style="height: 3px; width: 4rem; background-color: #E5E7EB; margin: 1.5rem auto; border-radius: 999px;"></div>
                    </div>

                    <form action="{{ route('booking.store', $package->id) }}" method="POST" class="space-y-6" id="bookingForm">
                        @csrf

                        <div class="flex flex-col">
                            <label class="label-style">Nama Rombongan / Group / Travel</label>
                            <input type="text" name="nama_group" value="{{ old('nama_group') }}" placeholder="Contoh: Group Haji Ahmad / Travel XYZ" class="form-input" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col">
                                <label class="label-style">
                                    {{ $package->category == 'transport_only' ? 'Detail Layanan' : 'Konfirmasi Nama Hotel' }}
                                </label>
                                <input type="text" name="nama_hotel" value="{{ $package->nama_paket }}" class="form-input" style="background-color: #F1F5F9; color: #475569;" readonly>
                            </div>

                            {{-- Input Hidden ditempatkan di sini agar struktur grid tetap valid --}}
                            <input type="hidden" name="jenis_kamar" value="Mixed/Flat">
                        </div>

                        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                            <div style="flex: 1; min-width: 200px;" class="flex flex-col">
                                <label class="label-style">
                                    {{ $package->category == 'transport_only' ? 'Tanggal Mulai Sewa' : 'Tanggal Check-In' }}
                                </label>
                                <input type="date" name="check_in" id="check_in" value="{{ old('check_in') }}" class="form-input" required>
                            </div>
                            <div style="flex: 1; min-width: 200px;" class="flex flex-col">
                                <label class="label-style">
                                    {{ $package->category == 'transport_only' ? 'Tanggal Selesai' : 'Tanggal Check-Out' }}
                                </label>
                                <input type="date" name="check_out" id="check_out" value="{{ old('check_out') }}" class="form-input" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex flex-col">
                                <label class="label-style">
                                    {{ $package->category == 'transport_only' ? 'Jumlah Unit (Bus)' : 'Jumlah Kamar' }}
                                </label>
                                <input type="number" name="jumlah_kamar" id="jumlah_kamar" value="{{ old('jumlah_kamar') }}" min="1" placeholder="0" class="form-input" required>
                            </div>
                            <div class="flex flex-col">
                                <label class="label-style">Total Jamaah / Personel (Pax)</label>
                                <input type="number" name="jumlah_pax" id="jumlah_pax" value="{{ old('jumlah_pax') }}" min="1" placeholder="0" class="form-input" required>
                            </div>
                        </div>

                        <div class="flex flex-col">
                            <label class="label-style">WhatsApp Agen (PIC)</label>
                            <input type="text" name="phone" value="{{ auth()->user()->no_wa }}" class="form-input" style="background-color: #F1F5F9; color: #475569;" readonly>
                        </div>

                        <div class="total-box shadow-xl">
                            <div>
                                <p style="color: rgba(255,255,255,0.7); font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em;">Estimasi Total Tagihan</p>
                                <h2 id="displayTotal" style="font-size: 2.25rem; font-weight: 900; margin-top: 0.25rem;">Rp 0</h2>
                                <p style="color: #C5A367; font-size: 0.65rem; font-weight: 700; margin-top: 0.4rem;">
                                    * Kurs Kantor: 1 {{ $package->currency }} = Rp {{ number_format($currentRate ?? 4200, 0, ',', '.') }}
                                    <br>
                                    <span style="font-style: italic; opacity: 0.8;">
                                        {{ $package->category == 'transport_only' ? '(Dihitung per Unit Armada)' : '(Dihitung per Jamaah/Pax)' }}
                                    </span>
                                </p>
                            </div>
                            <button type="submit" class="btn-confirm">
                                Booking Sekarang
                            </button>
                        </div>

                        <div class="text-center pt-6">
                            <a href="{{ route('dashboard') }}" style="color: #94A3B8; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#C5A367'" onmouseout="this.style.color='#94A3B8'">
                                ← Batal & Kembali ke Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <p style="margin-top: 3rem; text-align: center; font-size: 0.65rem; color: #2C4E58; opacity: 0.3; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5em;">
                PT Bintang Global Wisata &copy; 2026
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputPax = document.getElementById('jumlah_pax');
            const inputUnit = document.getElementById('jumlah_kamar');
            const displayTotal = document.getElementById('displayTotal');

            const hargaAgen = {{ $package->harga_agen }};
            const kurs = {{ $currentRate ?? 4200 }};
            const category = "{{ $package->category }}";

            function calculateTotal() {
                let total = 0;

                if (category === 'transport_only') {
                    const unit = parseFloat(inputUnit.value) || 0;
                    total = hargaAgen * kurs * unit;
                } else {
                    const pax = parseFloat(inputPax.value) || 0;
                    total = hargaAgen * kurs * pax;
                }

                displayTotal.innerText = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    maximumFractionDigits: 0
                }).format(total).replace(/\s/g, ' ');
            }

            inputPax.addEventListener('input', calculateTotal);
            inputUnit.addEventListener('input', calculateTotal);

            if(inputPax.value || inputUnit.value) calculateTotal();

            const checkInInput = document.getElementById('check_in');
            const checkOutInput = document.getElementById('check_out');

            checkInInput.addEventListener('change', function() {
                checkOutInput.min = this.value;
            });
        });
    </script>
</x-app-layout>
