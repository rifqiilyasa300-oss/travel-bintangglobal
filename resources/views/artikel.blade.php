<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="relative bg-[#2C4E58] py-16 px-6 text-center text-white">
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative z-10">
            <h1 class="text-4xl font-extrabold mb-2 uppercase tracking-wide">Artikel Blog</h1>
            <p class="text-gray-200">Baca juga informasi menarik, tips & trik seputar traveling dari Bintang Global!</p>

            <form action="{{ route('artikel') }}" method="GET" class="mt-8 max-w-3xl mx-auto flex flex-wrap gap-2 justify-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci artikel..." class="flex-grow px-4 py-3 rounded-lg text-gray-800 outline-none shadow-inner">
                <button type="submit" class="bg-[#C5A367] hover:bg-[#b3925a] px-8 py-3 rounded-lg font-bold transition shadow-md">🔍 Cari Artikel</button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-12 px-6">
        <div class="flex flex-col lg:flex-row gap-10">

            <div class="flex-[2]">
                @forelse($artikels as $artikel)
                    <div class="flex flex-col md:flex-row gap-6 mb-12 border-b border-gray-200 pb-10 group">
                        <div class="w-full md:w-72 h-48 overflow-hidden rounded-xl shadow-md bg-gray-200">
                            @if($artikel->gambar)
                                <img src="{{ asset('uploads/artikel/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-[#2C4E58] mb-2 hover:text-[#C5A367] transition">
                                <a href="{{ route('artikel.detail', $artikel->id) }}">{{ $artikel->judul }}</a>
                            </h3>
                            <div class="flex flex-wrap gap-4 text-xs text-gray-500 mb-4 font-medium">
                                <span>📅 {{ $artikel->created_at->format('d F Y') }}</span>
                                <span>👁️ {{ $artikel->views ?? 0 }}x dilihat</span>
                                <span>📁 Umum</span>
                            </div>
                            <p class="text-gray-600 leading-relaxed mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($artikel->konten), 200) }}
                            </p>
                            <a href="{{ route('artikel.detail', $artikel->id) }}" class="text-[#C5A367] font-bold hover:text-[#2C4E58] transition underline underline-offset-4">selengkapnya</a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-gray-200 shadow-sm">
                        <div class="text-6xl mb-4">📝</div>
                        <h3 class="text-xl font-bold text-[#2C4E58] mb-2">Belum Ada Artikel</h3>
                        <p class="text-gray-400">Admin belum menerbitkan artikel untuk saat ini. Silakan kembali lagi nanti!</p>
                        @if(request('search'))
                            <a href="{{ route('artikel') }}" class="mt-4 inline-block text-[#C5A367] font-bold italic">Tampilkan semua artikel</a>
                        @endif
                    </div>
                @endforelse

                <div class="mt-8">
                    {{ $artikels->links() }}
                </div>
            </div>

            <div class="flex-1 lg:max-w-[350px]">
                <div class="sticky top-6 space-y-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h5 class="text-[#2C4E58] font-bold mb-6 flex items-center gap-2">
                            🔍 Cari Paket Impian Anda!
                        </h5>
                        <form action="{{ route('dashboard') }}" method="GET" class="space-y-4">
                            <select name="category" class="w-full p-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-[#2C4E58] outline-none bg-gray-50">
                                <option value="">Semua Kategori</option>
                                <option value="umroh_full">Paket Umroh</option>
                                <option value="hotel_only">Wholesale Hotel</option>
                                <option value="transport_only">Bus & Transport</option>
                            </select>
                            <button type="submit" class="w-full bg-[#2C4E58] text-white py-3 rounded-xl font-bold uppercase tracking-wider hover:bg-[#1e363d] transition shadow-md">
                                Cari Paket
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
