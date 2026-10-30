<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="max-w-7xl mx-auto py-12 px-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
            <div>
                <h2 class="text-4xl font-black text-[#2C4E58] tracking-tight">📰 Manajemen Artikel</h2>
                <p class="text-gray-500 mt-1">Kelola konten berita dan informasi untuk jamaah Bintang Global.</p>
            </div>
            <a href="{{ route('admin.artikel.create') }}" class="bg-[#2C4E58] hover:bg-[#3d6b78] text-white px-8 py-4 rounded-2xl font-bold transition shadow-lg transform hover:scale-105 flex items-center gap-2 text-lg">
                <span class="text-2xl">+</span> Tulis Artikel Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-5 rounded-xl mb-10 shadow-sm flex items-center">
                <span class="text-2xl mr-3">✅</span>
                <p class="font-bold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($artikels as $artikel)
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-xl border border-gray-100 flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group">

                    <div class="p-4 pb-0"> <div class="relative h-48 w-full overflow-hidden rounded-[2rem] bg-gray-100 shadow-inner">
                            @if($artikel->gambar)
                                <img src="{{ asset('uploads/artikel/' . $artikel->gambar) }}"
                                     alt="{{ $artikel->judul }}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <span class="text-4xl mb-2">📸</span>
                                    <span class="font-bold text-[10px] uppercase tracking-widest">No Image</span>
                                </div>
                            @endif

                            <div class="absolute top-3 left-3">
                                <span class="bg-white/90 backdrop-blur-sm text-[#2C4E58] text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                                    Published
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 pt-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-2 text-[10px] text-gray-400 mb-3 font-medium uppercase tracking-wider">
                            <span>📅 {{ $artikel->created_at->format('d M Y') }}</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span>📁 Umum</span>
                        </div>

                        <h4 class="text-xl font-extrabold text-[#2C4E58] mb-4 line-clamp-2 leading-tight group-hover:text-[#C5A367] transition-colors h-[50px]">
                            {{ $artikel->judul }}
                        </h4>

                        <p class="text-gray-500 text-sm mb-8 line-clamp-3 leading-relaxed h-[63px]">
                            {{ Str::limit(strip_tags($artikel->konten), 120) }}
                        </p>

                        <div class="mt-auto pt-6 border-t border-gray-50 flex gap-4">
                            <a href="{{ route('admin.artikel.edit', $artikel->id) }}"
                               class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-center py-3 rounded-xl text-xs font-bold transition-all border border-blue-100 flex items-center justify-center gap-2">
                                ✏️ Edit
                            </a>

                            <form action="{{ route('admin.artikel.destroy', $artikel->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-50 hover:bg-red-500 hover:text-white text-red-500 py-3 rounded-xl text-xs font-bold transition-all border border-red-100 flex items-center justify-center gap-2">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-[3rem] py-24 border-4 border-dashed border-gray-100 text-center shadow-inner">
                    <div class="text-9xl mb-8">📭</div>
                    <h3 class="text-2xl font-black text-gray-400 uppercase tracking-widest mb-3">Belum Ada Artikel</h3>
                    <p class="text-gray-400">Mulai tulis berita atau informasi menarik untuk jamaah Bintang Global.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-16">
            {{ $artikels->links() }}
        </div>
    </div>
</x-app-layout>
