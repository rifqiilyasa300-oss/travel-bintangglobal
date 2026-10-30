<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="max-w-4xl mx-auto py-12 px-6">
        <div class="bg-white rounded-[3rem] shadow-2xl p-10 border border-gray-100">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-black text-[#2C4E58]">✏️ Edit Artikel</h2>
                <a href="{{ route('admin.artikel.index') }}" class="text-gray-400 hover:text-red-500 font-bold transition">Kembali</a>
            </div>

            <form action="{{ route('admin.artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-[#2C4E58] mb-2 uppercase tracking-wide">Judul Artikel</label>
                        <input type="text" name="judul" value="{{ $artikel->judul }}" class="w-full rounded-2xl border-gray-200 focus:border-[#C5A367] focus:ring-[#C5A367] py-4 px-6 text-lg" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#2C4E58] mb-2 uppercase tracking-wide">Ganti Gambar Cover (Opsional)</label>
                        @if($artikel->gambar)
                            <div class="mb-4">
                                <p class="text-xs text-gray-400 mb-2">Gambar Saat Ini:</p>
                                <img src="{{ asset('uploads/artikel/' . $artikel->gambar) }}" class="w-32 h-20 object-cover rounded-lg shadow">
                            </div>
                        @endif
                        <input type="file" name="gambar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-[#2C4E58] hover:file:bg-gray-200">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-[#2C4E58] mb-2 uppercase tracking-wide">Konten / Isi Artikel</label>
                        <textarea name="konten" rows="12" class="w-full rounded-2xl border-gray-200 focus:border-[#C5A367] focus:ring-[#C5A367] py-4 px-6" required>{{ $artikel->konten }}</textarea>
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" class="w-full py-4 bg-[#C5A367] text-white rounded-2xl font-black text-lg hover:bg-[#b38f55] shadow-xl transition transform hover:scale-[1.01]">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
