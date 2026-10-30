<x-app-layout>
    <div style="background-color: #F9F7F2; min-height: 100vh; padding: 4rem 0; font-family: 'Inter', sans-serif;">
        <div class="max-w-3xl mx-auto px-4">

            <div class="mb-8">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-[#2C4E58] font-bold text-[11px] uppercase tracking-[0.2em] hover:text-[#C5A367] transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Panel Admin
                </a>
            </div>

            <div style="background-color: #ffffff; border-radius: 2rem; border-top: 12px solid #2C4E58; box-shadow: 0 40px 100px -20px rgba(44,78,88,0.15); overflow: hidden;">
                <div class="p-8 md:p-12">

                    <div class="text-center mb-12">
                        <h1 style="color: #2C4E58; font-size: 2.5rem; font-weight: 900; text-transform: uppercase; letter-spacing: -0.05em; line-height: 1;">
                            EDIT <span style="color: #C5A367;">PAKET</span>
                        </h1>
                        <div style="height: 4px; width: 50px; background: #C5A367; margin: 15px auto; border-radius: 10px;"></div>
                        <p style="color: #94a3b8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3em; font-size: 0.65rem;">
                            Update Data Informasi Paket Wisata
                        </p>
                    </div>

                    @if ($errors->any())
                        <div style="background-color: #fee2e2; color: #b91c1c; padding: 1.25rem; border-radius: 1rem; margin-bottom: 2rem; border: 1px solid #f87171; font-size: 0.85rem; font-weight: 600;">
                            <p class="mb-2">⚠️ Mohon periksa kembali inputan Anda:</p>
                            <ul style="margin-left: 1rem; list-style-type: disc;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        {{-- NAMA PAKET --}}
                        <div class="space-y-3">
                            <label style="color: #2C4E58; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center;">
                                <span style="width: 8px; height: 8px; background: #C5A367; display: inline-block; margin-right: 10px; border-radius: 2px;"></span>
                                Nama Paket Wisata / Umroh
                            </label>
                            <input type="text" name="nama_paket" value="{{ old('nama_paket', $package->nama_paket) }}" required
                                style="width: 100%; padding: 1.25rem; background-color: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; color: #2C4E58; font-weight: 700; font-size: 1.1rem; outline: none; transition: all 0.3s;">
                        </div>

                        {{-- KATEGORI PAKET --}}
                        <div class="space-y-3">
                            <label style="color: #2C4E58; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center;">
                                <span style="width: 8px; height: 8px; background: #C5A367; display: inline-block; margin-right: 10px; border-radius: 2px;"></span>
                                Kategori Layanan
                            </label>
                            <select name="category" id="category-select"
                                style="width: 100%; padding: 1.25rem; background-color: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; color: #2C4E58; font-weight: 700; outline: none; cursor: pointer;">
                                <option value="umroh_full" {{ old('category', $package->category) == 'umroh_full' ? 'selected' : '' }}>PAKET UMROH / WISATA (BIRU)</option>
                                <option value="hotel_only" {{ old('category', $package->category) == 'hotel_only' ? 'selected' : '' }}>WHOLESALE HOTEL (KUNING)</option>
                                <option value="transport_only" {{ old('category', $package->category) == 'transport_only' ? 'selected' : '' }}>BUS & TRANSPORT (HIJAU)</option>
                            </select>
                        </div>



                        {{-- FOTO PAKET --}}
                        <div class="space-y-3">
                            <label style="color: #2C4E58; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center;">
                                <span style="width: 8px; height: 8px; background: #C5A367; display: inline-block; margin-right: 10px; border-radius: 2px;"></span>
                                Foto Paket
                            </label>

                            @if($package->image)
                                <div style="margin-bottom: 10px;">
                                    <p style="font-size: 10px; font-weight: 800; color: #94a3b8; margin-bottom: 5px;">FOTO SAAT INI:</p>
                                    <img src="{{ asset('uploads/packages/' . $package->image) }}" style="width: 150px; border-radius: 1rem; border: 2px solid #e2e8f0;">
                                </div>
                            @endif

                            <div style="border: 2px dashed #e2e8f0; padding: 1.5rem; border-radius: 1rem; background: #f8fafc;">
                                <input type="file" name="image" accept="image/*" style="font-size: 0.8rem; color: #64748b;">
                                <p style="margin-top: 8px; font-size: 10px; color: #C5A367; font-weight: 700;">*Biarkan kosong jika tidak ingin mengganti gambar.</p>
                            </div>
                        </div>

                        {{-- DESKRIPSI --}}
                        <div class="space-y-3">
                            <label style="color: #2C4E58; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center;">
                                <span style="width: 8px; height: 8px; background: #C5A367; display: inline-block; margin-right: 10px; border-radius: 2px;"></span>
                                Deskripsi & Fasilitas
                            </label>
                            <textarea name="deskripsi" rows="6"
                                style="width: 100%; padding: 1.25rem; background-color: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; color: #2C4E58; font-weight: 600; font-size: 1rem; outline: none;">{{ old('deskripsi', $package->deskripsi) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            {{-- HARGA --}}
                            <div class="space-y-3">
                                <label style="color: #2C4E58; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center;">
                                    <span style="width: 8px; height: 8px; background: #C5A367; display: inline-block; margin-right: 10px; border-radius: 2px;"></span>
                                    Harga & Mata Uang
                                </label>
                                <div style="display: flex; gap: 10px;">
                                    <select name="currency"
                                        style="width: 100px; padding: 1.25rem; background-color: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; color: #2C4E58; font-weight: 800; outline: none; cursor: pointer;">
                                        <option value="IDR" {{ old('currency', $package->currency) == 'IDR' ? 'selected' : '' }}>Rp</option>
                                        <option value="SAR" {{ old('currency', $package->currency) == 'SAR' ? 'selected' : '' }}>SAR</option>
                                        <option value="USD" {{ old('currency', $package->currency) == 'USD' ? 'selected' : '' }}>$</option>
                                    </select>

                                    <input type="number" name="harga_agen" value="{{ old('harga_agen', $package->harga_agen) }}" required
                                        style="flex: 1; padding: 1.25rem; background-color: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; color: #166534; font-weight: 800; font-size: 1.25rem; outline: none;">
                                </div>
                            </div>

                            {{-- STOK --}}
                            <div class="space-y-3">
                                <label style="color: #2C4E58; font-size: 0.75rem; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center;">
                                    <span style="width: 8px; height: 8px; background: #C5A367; display: inline-block; margin-right: 10px; border-radius: 2px;"></span>
                                    <span id="label-stok">Stok Kursi (Total)</span>
                                </label>
                                <div style="position: relative; display: flex; align-items: center;">
                                    <input type="number" name="stok_kursi" value="{{ old('stok_kursi', $package->kuota_awal) }}" required
                                        style="width: 100%; padding: 1.25rem; background-color: #f8fafc; border: 2px solid #e2e8f0; border-radius: 1rem; color: #2C4E58; font-weight: 800; font-size: 1.25rem; outline: none;">
                                    <span id="unit-stok" style="position: absolute; right: 1.25rem; font-weight: 900; color: #94a3b8; font-size: 0.7rem; text-transform: uppercase;">Pax</span>
                                </div>
                            </div>
                        </div>

                        {{-- ACTION BUTTONS --}}
                        <div class="pt-6 flex flex-col md:flex-row gap-4">
                            <button type="submit"
                                style="flex: 2; background: linear-gradient(135deg, #2C4E58 0%, #1a2e34 100%); color: #ffffff; font-weight: 900; padding: 1.5rem; border-radius: 1rem; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 0.2em; transition: all 0.3s; border: none; cursor: pointer; box-shadow: 0 15px 30px rgba(44,78,88,0.25);"
                                onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';" >
                                Simpan Perubahan
                            </button>

                            <a href="{{ route('admin.dashboard') }}"
                                style="flex: 1; background-color: #ffffff; color: #64748b; font-weight: 800; padding: 1.5rem; border-radius: 1rem; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.15em; text-align: center; transition: all 0.3s; text-decoration: none; border: 2px solid #e2e8f0;">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT FIXED --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category-select');
            const labelStok = document.getElementById('label-stok');
            const unitStok = document.getElementById('unit-stok');

            function updateUI() {
                // Hanya ubah label stok, jangan sembunyikan status bus
                if (categorySelect.value === 'hotel_only') {
                    labelStok.textContent = 'STOK KAMAR (TOTAL)';
                    unitStok.textContent = 'UNIT';
                } else if (categorySelect.value === 'transport_only') {
                    labelStok.textContent = 'STOK ARMADA (TOTAL)';
                    unitStok.textContent = 'UNIT';
                } else {
                    labelStok.textContent = 'STOK KURSI (TOTAL)';
                    unitStok.textContent = 'PAX';
                }
            }

            updateUI();
            categorySelect.addEventListener('change', updateUI);
        });
    </script>
</x-app-layout>
