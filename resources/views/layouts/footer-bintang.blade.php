<footer class="bg-[#2C4E58] text-white py-8 px-6 md:px-12">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-6">
            <div class="max-w-xs">
                <h2 class="text-2xl font-bold mb-2">Bintang Global.</h2>
                <p class="text-gray-300 text-xs leading-relaxed">
                    Jl. Raya Condet No.8a, RT.5/RW.3, Balekambang, Kec. Kramat jati,
                    Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13530
                </p>
            </div>

            <div class="flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-12">
                <nav class="flex gap-6 text-sm">
                    <a href="{{ url('/') }}#tentang" class="font-semibold hover:text-gray-300 transition-colors">Tentang Kami</a>
                    <a href="{{ url('/') }}#layanan" class="font-semibold hover:text-gray-300 transition-colors">Layanan Kami</a>
                </nav>

                <div class="flex gap-3">
                    {{-- TikTok --}}
                    <a href="https://www.tiktok.com/@bintangglobal_grup" target="_blank" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <img src="{{ asset('images/tiktok.png') }}" alt="TikTok" class="w-4 h-4">
                    </a>

                    {{-- Instagram --}}
                    <a href="https://www.instagram.com/bintangglobal_grup?igsh=dmZxdWt4c20yaHNt" target="_blank" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <img src="{{ asset('images/instagram.png') }}" alt="Instagram" class="w-4 h-4">
                    </a>

                    {{-- Gmail --}}
                    <a href="mailto:admin@bintangglobal.co.id" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <img src="{{ asset('images/gmail.png') }}" alt="Email" class="w-4 h-4">
                    </a>

                    {{-- YouTube --}}
                    <a href="#" target="_blank" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <img src="{{ asset('images/youtube.png') }}" alt="YouTube" class="w-4 h-4">
                    </a>

                    {{-- LinkedIn --}}
                    <a href="#" target="_blank" class="w-8 h-8 bg-white rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                        <img src="{{ asset('images/linkedIn.png') }}" alt="LinkedIn" class="w-4 h-4">
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 pt-4 text-[10px] text-gray-400 text-center md:text-left">
            <p>© 2023 BintangGlobalGrup. All rights reserved | Developed by bintang global</p>
        </div>
    </div>
</footer>
