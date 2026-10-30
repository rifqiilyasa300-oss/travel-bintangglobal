<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="max-w-4xl mx-auto py-12 px-6">
        <div class="bg-white rounded-[3rem] shadow-2xl p-10 border border-gray-100">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-black text-[#2C4E58]">✍️ Buat Artikel Baru</h2>
                <a href="{{ route('admin.artikel.index') }}" class="text-gray-400 hover:text-red-500 font-bold transition">Kembali</a>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-xl">
                    <p class="font-bold">Opps! Ada yang salah:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-[#2C4E58] mb-2 uppercase tracking-wide">Judul Artikel</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" class="w-full rounded-2xl border-gray-200 focus:border-[#C5A367] focus:ring-[#C5A367] py-4 px-6 text-lg" placeholder="Masukkan judul..." required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#2C4E58] mb-2 uppercase tracking-wide">Upload Gambar Cover</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-[#C5A367] transition">
                            <div class="space-y-1 text-center">
                                <span class="text-4xl">📸</span>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label class="relative cursor-pointer bg-white rounded-md font-medium text-[#C5A367] hover:text-[#2C4E58] focus-within:outline-none">
                                        <span>Klik untuk pilih gambar</span>
                                        <input type="file" name="gambar" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#2C4E58] mb-2 uppercase tracking-wide">Konten / Isi Artikel</label>
                        <textarea name="konten" rows="12" class="w-full rounded-2xl border-gray-200 focus:border-[#C5A367] focus:ring-[#C5A367] py-4 px-6" placeholder="Tuliskan berita lengkap di sini..." required>{{ old('konten') }}</textarea>
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" class="w-full py-4 bg-[#2C4E58] text-white rounded-2xl font-black text-lg hover:bg-[#3d6b78] shadow-xl transition transform hover:scale-[1.01]">
                        🚀 Publikasikan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
