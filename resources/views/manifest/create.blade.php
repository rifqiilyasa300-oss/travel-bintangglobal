<x-app-layout>
    <div style="background-color: #F9F7F2; min-height: 100vh; padding: 3rem 0;">
        <div class="max-w-4xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="text-center mb-10">
                <h2 style="color: #2C4E58; font-weight: 900; text-transform: uppercase; font-size: 1.5rem; letter-spacing: 0.1em;">Data Manifest Jamaah</h2>
                <p class="text-[10px] font-bold text-[#C5A367] uppercase tracking-[0.2em] mt-2">
                    Menambah {{ $sisa_kuota }} Jamaah Baru (Total Kuota: {{ $booking->jumlah_jamaah }} Pax)
                </p>
                <div style="height: 3px; width: 4rem; background-color: #C5A367; margin: 1rem auto; border-radius: 999px;"></div>
            </div>

            {{-- TAMPILKAN ERROR VALIDASI --}}
            @if ($errors->any())
                <div style="background-color: #FEE2E2; border-left: 4px solid #EF4444; color: #991B1B; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <p class="font-black text-xs uppercase mb-2">⚠️ Terjadi Kesalahan:</p>
                    <ul class="text-[11px] list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('manifest.store', $booking->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-8">
                    {{-- LOOPING BERDASARKAN SISA KUOTA --}}
                    @for($i = 0; $i < $sisa_kuota; $i++)
                    <div style="background-color: #ffffff; border-radius: 1.5rem; border-top: 5px solid #C5A367; box-shadow: 0 15px 35px rgba(44,78,88,0.05);" class="p-8">
                        <div class="flex items-center gap-3 mb-8">
                            <span class="bg-[#2C4E58] text-white w-7 h-7 rounded-lg flex items-center justify-center text-[11px] font-black shadow-md">
                                {{ $sudah_isi + $i + 1 }}
                            </span>
                            <h3 style="color: #2C4E58; font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 0.1em;">Jamaah Ke-{{ $sudah_isi + $i + 1 }}</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-[9px] font-black text-gray-400 uppercase mb-2 ml-4">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap[]" required style="border-color: #E2E8F0; background-color: #F8FAFC;" class="w-full rounded-full text-sm font-bold text-[#2C4E58] py-3 px-6" placeholder="SESUAI PASPOR">
                            </div>

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase mb-2 ml-4">Grup / No. Kamar</label>
                                <input type="text" name="grup_kamar[]" required style="border-color: #E2E8F0; background-color: #F8FAFC;" class="w-full rounded-full text-sm font-bold text-[#2C4E58] py-3 px-6" placeholder="Contoh: Kamar 01">
                            </div>

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase mb-2 ml-4">Tipe Kamar</label>
                                <select name="tipe_kamar[]" required style="border-color: #E2E8F0; background-color: #F8FAFC;" class="w-full rounded-full text-sm font-bold text-[#2C4E58] py-3 px-6 appearance-none cursor-pointer">
                                    <option value="Double">DOUBLE (ISI 2)</option>
                                    <option value="Triple">TRIPLE (ISI 3)</option>
                                    <option value="Quad">QUAD (ISI 4)</option>
                                    <option value="Quint">QUINT (ISI 5)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase mb-2 ml-4">Nomor Paspor</label>
                                <input type="text" name="nomor_paspor[]" required style="border-color: #E2E8F0; background-color: #F8FAFC;" class="w-full rounded-full text-sm font-bold text-[#2C4E58] py-3 px-6">
                            </div>

                            <div>
                                <label class="block text-[9px] font-black text-gray-400 uppercase mb-2 ml-4">Jenis Kelamin</label>
                                <select name="jenis_kelamin[]" required style="border-color: #E2E8F0; background-color: #F8FAFC;" class="w-full rounded-full text-sm font-bold text-[#2C4E58] py-3 px-6 appearance-none">
                                    <option value="L">LAKI-LAKI</option>
                                    <option value="P">PEREMPUAN</option>
                                </select>
                            </div>

                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 pt-6 border-t border-gray-50">
                                <div>
                                    <label class="block text-[9px] font-black text-gray-400 uppercase mb-2 ml-4">Upload Paspor (Max 2MB)</label>
                                    <div style="border-color: #E2E8F0; background-color: #F8FAFC;" class="rounded-full px-4 py-2 border">
                                        {{-- Note: name pakai index $i agar file tidak tertukar --}}
                                        <input type="file" name="foto_paspor[{{ $i }}]" required class="text-[10px] w-full file:bg-[#2C4E58] file:text-white file:rounded-full file:border-0 file:px-3 file:py-1">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[9px] font-black text-gray-400 uppercase mb-2 ml-4">Upload Pasfoto (Max 2MB)</label>
                                    <div style="border-color: #E2E8F0; background-color: #F8FAFC;" class="rounded-full px-4 py-2 border">
                                        <input type="file" name="pasfoto[{{ $i }}]" required class="text-[10px] w-full file:bg-[#2C4E58] file:text-white file:rounded-full file:border-0 file:px-3 file:py-1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="mt-12 flex flex-col gap-4 max-w-sm mx-auto">
                    <button type="submit" style="background-color: #2C4E58;" class="w-full text-white font-black py-4 rounded-full uppercase text-[11px] tracking-[0.2em] shadow-xl hover:bg-black transition-all">
                        Simpan {{ $sisa_kuota }} Data Jamaah Sekaligus
                    </button>
                    <a href="{{ route('manifest.show', $booking->id) }}" class="text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-red-500">Lihat Daftar Jamaah</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
