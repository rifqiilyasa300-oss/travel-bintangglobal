<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bintang Global - Jelajahi Dunia Yang Indah</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            :root {
                --teal-bintang: #2C4E58;
                --gold-bintang: #C5A367;
                --bg-krem: #F9F7F2;
            }
            body {
                font-family: 'Figtree', sans-serif;
                background-color: var(--bg-krem);
                scroll-behavior: smooth;
                color: var(--teal-bintang);
            }

            .hero-section {
                position: relative;
                height: 100vh;
                width: 100%;
                background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                            url('{{ asset("images/hero-bg.jpg") }}');
                background-size: cover;
                background-position: center;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
                color: white;
            }

            .modal-open { overflow: hidden; }
            :target { scroll-margin-top: 100px; }

            .card-bintang {
                transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
            }
            .card-bintang:hover {
                transform: translateY(-12px);
                box-shadow: 0 25px 50px rgba(44, 78, 88, 0.15);
            }
        </style>
    </head>
    <body class="antialiased" x-data="{ openModal: false, modalImg: '', modalTitle: '', scrolled: false }"
          @scroll.window="scrolled = (window.pageYOffset > 50) ? true : false"
          :class="{ 'modal-open': openModal }">

        {{-- NAVIGASI --}}
        <nav class="fixed top-0 w-full z-50 transition-all duration-300"
             :class="scrolled ? 'bg-[var(--teal-bintang)] py-4 shadow-lg' : 'bg-transparent py-6'">
            <div class="max-w-7xl mx-auto px-10 flex justify-between items-center">
                <div class="text-2xl font-black text-white tracking-tighter uppercase">Bintang Global.</div>
                <div class="flex items-center gap-8">
                    <a href="#tentang" class="hidden md:block text-[10px] font-bold uppercase tracking-widest text-white hover:text-[var(--gold-bintang)] transition">Tentang Kami</a>
                    <a href="#layanan" class="hidden md:block text-[10px] font-bold uppercase tracking-widest text-white hover:text-[var(--gold-bintang)] transition">Layanan Kami</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-[10px] font-bold uppercase tracking-widest text-white border-b-2 border-[var(--gold-bintang)]">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[10px] font-bold uppercase tracking-widest text-white hover:text-[var(--gold-bintang)] transition">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-5 py-2 rounded-lg font-bold text-[10px] uppercase tracking-widest hover:bg-white hover:text-[var(--teal-bintang)] transition">Daftar Agen</a>
                    @endauth
                </div>
            </div>
        </nav>

       {{-- HERO SECTION --}}
<section class="hero-section px-6">
    <div class="max-w-5xl mx-auto flex flex-col items-center">
        <span class="text-[var(--gold-bintang)] font-black uppercase tracking-[0.4em] text-[10px] mb-4 bg-white/10 px-4 py-2 rounded-full backdrop-blur-sm">
            B2B Travel Partner
        </span>

        <h1 class="text-3xl md:text-5xl lg:text-6xl font-black uppercase leading-[1.2] tracking-tighter mb-6">
            Mulailah Perjalanan Ibadah Anda <br>
            <span class="text-[var(--gold-bintang)]">Bersama Kami, Amanah & Terpercaya</span>
        </h1>

        <div class="h-1 w-20 bg-[var(--gold-bintang)] mb-8 rounded-full"></div>

        <p class="text-base md:text-lg font-medium text-white/80 max-w-2xl leading-relaxed">
            Solusi portal booking umroh khusus agen. Kelola transaksi, kuota,
            dan keberangkatan jamaah dalam satu platform profesional.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 mt-10">
            <a href="#pemesanan" class="bg-white text-[var(--teal-bintang)] px-8 py-4 rounded-full font-black uppercase text-[10px] tracking-[0.2em] hover:bg-[var(--gold-bintang)] hover:text-white transition shadow-2xl hover:-translate-y-1">
                Lihat Paket
            </a>
            <a href="{{ route('register') }}" class="bg-transparent border-2 border-white/30 text-white px-8 py-4 rounded-full font-black uppercase text-[10px] tracking-[0.2em] hover:bg-white/10 transition backdrop-blur-md">
                Gabung Agen
            </a>
        </div>
    </div>
</section>

        <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full">

            {{-- Ikon Fitur --}}
            <div class="grid md:grid-cols-3 gap-8 -mt-20 relative z-10 mb-32">
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl text-center group">
                    <div class="w-16 h-16 bg-[var(--bg-krem)] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[var(--gold-bintang)] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--gold-bintang)] group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.143-7.714L1 12l7.714-2.143L11 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-black text-[var(--teal-bintang)] uppercase tracking-wider mb-3">Fasilitas Mewah</h3>
                    <p class="text-sm text-gray-500">Memberikan Anda pelayanan yang nyaman dan fasilitas yang lengkap.</p>
                </div>
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl text-center group">
                    <div class="w-16 h-16 bg-[var(--bg-krem)] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[var(--gold-bintang)] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--gold-bintang)] group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-black text-[var(--teal-bintang)] uppercase tracking-wider mb-3">Harga Terjangkau</h3>
                    <p class="text-sm text-gray-500">Mendapatkan perjalanan berkualitas dengan harga terjangkau.</p>
                </div>
                <div class="bg-white p-10 rounded-[2.5rem] shadow-xl text-center group">
                    <div class="w-16 h-16 bg-[var(--bg-krem)] rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:bg-[var(--gold-bintang)] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[var(--gold-bintang)] group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-black text-[var(--teal-bintang)] uppercase tracking-wider mb-3">Koneksi Luas</h3>
                    <p class="text-sm text-gray-500">Menawarkan perjalanan unik yang tidak ditemukan di tempat lain.</p>
                </div>
            </div>

            {{-- PEMESANAN PAKET (SYNCED WITH DASHBOARD STYLE) --}}
            <div id="pemesanan" class="mb-32">
                <div class="flex items-center gap-4 mb-10">
                    <h2 class="text-2xl font-black text-[var(--teal-bintang)] uppercase tracking-tighter">Paket Perjalanan Terbaru</h2>
                    <div class="h-px flex-grow bg-[var(--gold-bintang)]/20"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($packages as $p)
                    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-md card-bintang flex flex-col border border-gray-100 group">

                        {{-- Image Area - FIX: Poster Tidak Terpotong & Bisa Diklik Modal --}}
                        <div class="relative h-[400px] bg-gray-50 flex items-center justify-center p-4 overflow-hidden">
                            @if($p->image)
                                <img src="{{ asset('uploads/packages/' . $p->image) }}"
                                     class="max-w-full max-h-full object-contain drop-shadow-md rounded-xl transition duration-500 group-hover:scale-105 cursor-zoom-in"
                                     alt="{{ $p->nama_paket }}"
                                     @click="openModal = true; modalImg = '{{ asset('uploads/packages/' . $p->image) }}'; modalTitle = '{{ $p->nama_paket }}';">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300 font-bold text-[10px] tracking-widest uppercase">No Image</div>
                            @endif

                            <div class="absolute top-5 left-5">
                                <span class="px-4 py-1.5 {{ Str::contains(strtolower($p->category), 'umroh') ? 'bg-blue-600' : (Str::contains(strtolower($p->category), 'transport') ? 'bg-purple-600' : 'bg-[var(--gold-bintang)]') }} text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg">
                                    {{ str_replace('_', ' ', $p->category) }}
                                </span>
                            </div>
                        </div>

                        {{-- Content Area --}}
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="text-xl font-black text-[var(--teal-bintang)] uppercase leading-tight mb-4 min-h-[3rem]">{{ $p->nama_paket }}</h3>

                            <p class="text-gray-500 text-xs mb-6 line-clamp-3 italic leading-relaxed">
                                {{ strip_tags($p->deskripsi ?? 'Layanan terbaik untuk pengalaman perjalanan spiritual dan bisnis Anda yang tak terlupakan.') }}
                            </p>

                            <div class="mt-auto pt-6 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    <div class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Harga Nett</div>
                                    <div class="text-xl font-black text-[#14532D]">{{ $p->currency }} {{ number_format($p->harga_agen, 0, ',', '.') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Sisa Kursi</div>
                                    <div class="text-lg font-black text-[var(--teal-bintang)]">{{ $p->sisa_kuota }}<span class="text-xs text-gray-300">/{{ $p->kuota_awal }}</span></div>
                                </div>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="grid grid-cols-2 gap-3 mt-6">
                                <a href="{{ route('user.booking.show', $p->id) }}"
                                   class="bg-[var(--bg-krem)] text-[var(--teal-bintang)] text-center font-black py-3 rounded-xl uppercase text-[10px] tracking-widest hover:bg-[var(--gold-bintang)] hover:text-white transition shadow-sm">
                                    Detail
                                </a>

                                <a href="{{ route('booking.pendaftaran', $p->id) }}"
                                   class="bg-[var(--teal-bintang)] text-white text-center font-black py-3 rounded-xl uppercase text-[10px] tracking-widest hover:bg-black transition shadow-lg">
                                    Booking
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-20 text-center text-gray-300 font-black uppercase text-sm tracking-[0.5em]">
                        Belum Ada Paket Tersedia
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- TENTANG KAMI --}}
            <div id="tentang" class="grid md:grid-cols-2 gap-20 items-center mb-32 pt-20">
                <div>
                    <h4 class="text-[var(--gold-bintang)] font-black uppercase tracking-[0.3em] text-xs mb-4">Profil Perusahaan</h4>
                    <h2 class="text-4xl font-extrabold text-[var(--teal-bintang)] uppercase tracking-tighter mb-8">PT Bintang Global Grup</h2>
                    <div class="space-y-6 text-gray-500 leading-relaxed text-lg">
                        <p>
                            <span class="font-bold text-[var(--teal-bintang)]">PT. Bintang Global Grup</span> menawarkan layanan Land Arrangement, Paket Umrah, dan panduan perencanaan perjalanan Timur tengah lainnya bersama <span class="italic">Farika Wisata</span> sejak tahun 2015.
                        </p>
                        <p>
                            Dengan koneksi kami yang luas, kami dapat menawarkan promosi perjalanan unik yang tidak dapat Anda temukan di tempat lain. Kami di sini untuk menjadikan pengalaman bisnis perjalanan wisata Anda semulus dan senyaman mungkin.
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <div class="absolute -inset-4 bg-[var(--gold-bintang)]/10 rounded-[3rem] rotate-3"></div>
                    <img src="{{ asset('images/mekkah.png') }}" class="relative rounded-[2.5rem] shadow-2xl" alt="Mekkah">
                </div>
            </div>

            {{-- LAYANAN KAMI --}}
            <div id="layanan" class="mb-32 pt-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-extrabold text-[var(--teal-bintang)] uppercase tracking-tighter mb-4">Layanan Kami</h2>
                        <p class="text-gray-500 mb-12">Kami memiliki beberapa layanan yang dapat Anda lihat di bawah ini</p>
                        <div class="space-y-6">
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-md transition">
                                <div class="text-3xl bg-[var(--bg-krem)] w-16 h-16 flex items-center justify-center rounded-xl">✈️</div>
                                <div>
                                    <h4 class="font-black text-[var(--teal-bintang)] uppercase tracking-wider text-sm">Tiket Transportasi</h4>
                                    <p class="text-xs text-gray-500 font-medium">Transportasi selama di Mekkah dan Madinah.</p>
                                </div>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-md transition">
                                <div class="text-3xl bg-[var(--bg-krem)] w-16 h-16 flex items-center justify-center rounded-xl">🏨</div>
                                <div>
                                    <h4 class="font-black text-[var(--teal-bintang)] uppercase tracking-wider text-sm">Paket Hotel</h4>
                                    <p class="text-xs text-gray-500 font-medium">Hotel Mekkah dan Madinah.</p>
                                </div>
                            </div>
                            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-md transition">
                                <div class="text-3xl bg-[var(--bg-krem)] w-16 h-16 flex items-center justify-center rounded-xl">🕋</div>
                                <div>
                                    <h4 class="font-black text-[var(--teal-bintang)] uppercase tracking-wider text-sm">Paket Umroh</h4>
                                    <p class="text-xs text-gray-500 font-medium">Paket Perjalanan, Anda hanya perlu membawa koper.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 h-[500px]">
                        <div class="space-y-4">
                            <img src="{{ asset('images/kabah.jpg') }}" class="w-full h-3/5 object-cover rounded-[2rem] shadow-lg" alt="Kabah">
                            <div class="bg-[var(--teal-bintang)] w-full h-2/5 rounded-[2rem] overflow-hidden shadow-lg">
                                <img src="{{ asset('images/kereta.jpg') }}" class="w-full h-full object-cover opacity-90" alt="Kereta">
                            </div>
                        </div>
                        <div class="pt-12">
                            <img src="{{ asset('images/kasur.jpg') }}" class="w-full h-full object-cover rounded-[2rem] shadow-lg" alt="Hotel">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- MODAL PREVIEW (LIGHTBOX) --}}
        <div x-show="openModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex flex-col items-center justify-center p-6 bg-black/95 backdrop-blur-md"
             style="display: none;">

            <button @click="openModal = false" class="absolute top-6 right-8 text-white text-5xl hover:text-[var(--gold-bintang)] transition">&times;</button>

            <div class="max-w-4xl w-full flex flex-col items-center" @click.away="openModal = false">
                <img :src="modalImg" class="max-h-[80vh] w-auto object-contain rounded-lg shadow-2xl shadow-white/10">
                <h2 class="text-xl text-white font-black uppercase tracking-widest mt-6 text-center" x-text="modalTitle"></h2>
                <button @click="openModal = false" class="mt-4 text-xs font-bold text-gray-400 uppercase tracking-[0.2em] border-b border-gray-600 pb-1 hover:text-white transition">Tutup Pratinjau</button>
            </div>
        </div>

        {{-- FOOTER --}}
        @include('layouts.footer-bintang')
    </body>
</html>
