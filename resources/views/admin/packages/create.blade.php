<x-app-layout>
    <div style="background: linear-gradient(135deg, #F9F7F2 0%, #F0EBE0 100%); min-height: 100vh; padding: 3rem 0; font-family: 'Plus Jakarta Sans', sans-serif;">

        <div style="max-width: 900px; margin: 0 auto; padding: 0 1.5rem;">

            {{-- TOMBOL KEMBALI --}}
            <div class="mb-8">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-[#2C4E58] font-bold text-[11px] uppercase tracking-[2px] hover:text-[#C5A367] transition-all group">
                    <div style="background: white; padding: 8px; border-radius: 50%; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-right: 12px; transition: 0.3s;" class="group-hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    </div>
                    Kembali ke Panel Admin
                </a>
            </div>

            {{-- CARD FORM --}}
            <div style="background: #ffffff; border-radius: 2rem; box-shadow: 0 30px 60px rgba(44,78,88,0.12); overflow: hidden; border: 1px solid rgba(255,255,255,0.8);">

                {{-- ACCENT BAR --}}
                <div style="height: 10px; background: linear-gradient(90deg, #2C4E58 0%, #C5A367 100%);"></div>

                <div class="p-8 md:p-12">

                    {{-- HEADER --}}
                    <div class="text-center mb-12">
                        <span style="color: #C5A367; font-weight: 800; font-size: 12px; letter-spacing: 3px; text-transform: uppercase;">Service Management</span>
                        <h1 style="color: #2C4E58; font-size: 2.2rem; font-weight: 900; margin-top: 0.5rem; letter-spacing: -0.03em;">
                            TAMBAH <span style="color: #C5A367; font-style: italic;">DATA LAYANAN</span>
                        </h1>
                        <p style="color: #64748b; font-size: 14px; margin-top: 10px;">Input detail paket umroh, hotel, atau transportasi baru</p>
                    </div>

                    {{-- ERROR HANDLING --}}
                    @if ($errors->any())
                        <div style="background: #FFF5F5; border-left: 4px solid #F87171; padding: 1.5rem; border-radius: 1rem; margin-bottom: 2rem;">
                            <h3 style="color: #991B1B; font-weight: 800; font-size: 13px; text-transform: uppercase; margin-bottom: 8px;">Mohon periksa kembali:</h3>
                            <ul style="color: #B91C1C; font-size: 13px; list-style-type: disc; margin-left: 1.2rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM START --}}
                    <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        {{-- NAMA PAKET --}}
                        <div class="group">
                            <label style="color: #2C4E58; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 10px;">Nama Layanan / Paket / Hotel</label>
                            <input type="text" name="nama_paket" required value="{{ old('nama_paket') }}" placeholder="Contoh: Umroh Exclusive Ramadhan 2024"
                                style="width: 100%; padding: 1.1rem 1.5rem; background-color: #F8FAFC; border: 2px solid #E2E8F0; border-radius: 1.2rem; color: #2C4E58; font-weight: 600; font-size: 15px; transition: 0.3s; outline: none;"
                                onfocus="this.style.borderColor='#C5A367'; this.style.backgroundColor='#fff'; this.style.boxShadow='0 10px 20px rgba(197,163,103,0.1)'"
                                onblur="this.style.borderColor='#E2E8F0'; this.style.backgroundColor='#F8FAFC'; this.style.boxShadow='none'">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- KATEGORI --}}
                            <div>
                                <label style="color: #2C4E58; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 10px;">Jenis Layanan</label>
                                <select name="category" id="category-select" required
                                    style="width: 100%; padding: 1.1rem 1.5rem; background-color: #F8FAFC; border: 2px solid #E2E8F0; border-radius: 1.2rem; color: #2C4E58; font-weight: 700; font-size: 14px; outline: none; appearance: none; cursor: pointer;">
                                    <option value="umroh_full">📦 PAKET UMROH / WISATA</option>
                                    <option value="hotel_only">🏨 WHOLESALE HOTEL</option>
                                    <option value="transport_only">🚌 BUS & TRANSPORTASI</option>
                                </select>
                            </div>

                            {{-- FOTO --}}
                            <div>
                                <label style="color: #2C4E58; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 10px;">Foto / Poster</label>
                                <div style="position: relative;">
                                    <input type="file" name="image" accept="image/*" required
                                        style="width: 100%; padding: 0.9rem; background-color: #F8FAFC; border: 2px dashed #CBD5E1; border-radius: 1.2rem; color: #64748B; font-size: 13px; outline: none;">
                                </div>
                            </div>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div>
                            <label style="color: #2C4E58; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 10px;">Deskripsi & Fasilitas</label>
                            <textarea name="deskripsi" rows="5" required placeholder="Jelaskan detail fasilitas, durasi, dan keunggulan paket..."
                                style="width: 100%; padding: 1.1rem 1.5rem; background-color: #F8FAFC; border: 2px solid #E2E8F0; border-radius: 1.2rem; color: #2C4E58; font-weight: 500; font-size: 15px; transition: 0.3s; outline: none; resize: none;"
                                onfocus="this.style.borderColor='#C5A367'; this.style.backgroundColor='#fff'"
                                onblur="this.style.borderColor='#E2E8F0'; this.style.backgroundColor='#F8FAFC'">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- HARGA --}}
                            <div>
                                <label style="color: #2C4E58; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 10px;">Harga Agen</label>
                                <div style="display: flex; gap: 10px;">
                                    <select name="currency" style="width: 100px; padding: 1.1rem; background-color: #2C4E58; border: none; border-radius: 1.2rem; color: #fff; font-weight: 800; font-size: 14px; outline: none; cursor: pointer;">
                                        <option value="SAR">SAR</option>
                                        <option value="IDR">IDR</option>
                                        <option value="USD">USD</option>
                                    </select>
                                    <input type="number" name="harga_agen" required value="{{ old('harga_agen') }}" placeholder="0"
                                        style="flex: 1; padding: 1.1rem 1.5rem; background-color: #F8FAFC; border: 2px solid #E2E8F0; border-radius: 1.2rem; color: #166534; font-weight: 800; font-size: 18px; outline: none;"
                                        onfocus="this.style.borderColor='#166534'">
                                </div>
                            </div>

                            {{-- STOK --}}
                            <div>
                                <label style="color: #2C4E58; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; display: block; margin-bottom: 10px;">
                                    <span id="label-stok">STOK KURSI (TOTAL)</span>
                                </label>
                                <div style="position: relative; display: flex; align-items: center;">
                                    <input type="number" name="stok_kursi" required value="{{ old('stok_kursi') }}" placeholder="0"
                                        style="width: 100%; padding: 1.1rem 1.5rem; background-color: #F8FAFC; border: 2px solid #E2E8F0; border-radius: 1.2rem; color: #2C4E58; font-weight: 800; font-size: 18px; outline: none;"
                                        onfocus="this.style.borderColor='#C5A367'">
                                    <span id="unit-stok" style="position: absolute; right: 1.5rem; font-weight: 900; color: #94A3B8; font-size: 12px; background: white; padding: 4px 10px; border-radius: 8px;">PAX</span>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="pt-8 flex flex-col md:flex-row gap-4">
                            <button type="submit"
                                style="flex: 2; background: linear-gradient(135deg, #2C4E58 0%, #1a2f35 100%); color: #fff; font-weight: 800; padding: 1.2rem; border-radius: 1.2rem; text-transform: uppercase; font-size: 14px; letter-spacing: 2px; border: none; cursor: pointer; transition: 0.4s; box-shadow: 0 10px 20px rgba(44,78,88,0.2);"
                                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 30px rgba(44,78,88,0.3)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 20px rgba(44,78,88,0.2)'">
                                🚀 Simpan Layanan Baru
                            </button>
                            <a href="{{ route('admin.dashboard') }}"
                                style="flex: 1; background-color: #fff; color: #64748B; font-weight: 700; padding: 1.2rem; border-radius: 1.2rem; text-transform: uppercase; font-size: 13px; text-align: center; border: 2px solid #E2E8F0; transition: 0.3s; display: flex; align-items: center; justify-content: center;"
                                onmouseover="this.style.backgroundColor='#F1F5F9'">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- FOOTER INFO --}}
            <div class="text-center mt-8">
                <p style="color: #94A3B8; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                    &copy; {{ date('Y') }} Admin Inventory System • Premium Quality Service
                </p>
            </div>
        </div>
    </div>

    {{-- SCRIPT UPDATE UI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category-select');
            const labelStok = document.getElementById('label-stok');
            const unitStok = document.getElementById('unit-stok');

            function updateStokUI() {
                if (categorySelect.value === 'hotel_only') {
                    labelStok.innerText = 'STOK KAMAR (TOTAL)';
                    unitStok.innerText = 'UNIT';
                } else if (categorySelect.value === 'transport_only') {
                    labelStok.innerText = 'STOK ARMADA (TOTAL)';
                    unitStok.innerText = 'UNIT';
                } else {
                    labelStok.innerText = 'STOK KURSI (TOTAL)';
                    unitStok.innerText = 'PAX';
                }
            }

            updateStokUI();
            categorySelect.addEventListener('change', updateStokUI);
        });
    </script>
</x-app-layout>
