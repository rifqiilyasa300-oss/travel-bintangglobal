<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="max-w-4xl mx-auto py-12 px-6">
        <a href="{{ route('artikel') }}" class="inline-flex items-center text-[#2C4E58] font-bold mb-8 hover:text-[#C5A367] transition">
            ⬅️ Kembali ke Daftar Artikel
        </a>

        <article class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-gray-100">
            <div class="w-full h-[400px] bg-gray-200">
                @if($artikel->gambar)
                    <img src="{{ asset('uploads/artikel/' . $artikel->gambar) }}" alt="{{ $artikel->judul }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Image Available</div>
                @endif
            </div>

            <div class="p-10 md:p-16">
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6 font-medium uppercase tracking-widest">
                    <span>📅 {{ $artikel->created_at->format('d F Y') }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#C5A367]"></span>
                    <span>👤 Admin Bintang Global</span>
                </div>

                <h1 class="text-4xl md:text-5xl font-black text-[#2C4E58] mb-8 leading-tight">
                    {{ $artikel->judul }}
                </h1>

                <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed space-y-6">
                    {!! nl2br(e($artikel->konten)) !!}
                </div>

                <div class="mt-16 pt-8 border-t border-gray-100 flex justify-between items-center">
                    <div class="flex gap-2">
                        <span class="px-4 py-2 bg-gray-100 rounded-full text-xs font-bold text-gray-500">#Traveling</span>
                        <span class="px-4 py-2 bg-gray-100 rounded-full text-xs font-bold text-gray-500">#BintangGlobal</span>
                    </div>
                    <div class="text-sm text-gray-400 italic">
                        Dilihat {{ $artikel->views ?? 0 }} kali
                    </div>
                </div>
            </div>
        </article>
    </div>
</x-app-layout>
