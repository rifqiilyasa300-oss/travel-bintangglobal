<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal Mitra - Bintang Global</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,800,900&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            :root {
                --teal-bintang: #2C4E58; /* Background Navbar sesuai screenshot */
                --gold-bintang: #C5A367;
                --bg-krem: #F9F7F2;
            }
            body {
                background-color: var(--bg-krem);
                font-family: 'Figtree', sans-serif;
                color: var(--teal-bintang);
                margin: 0;
            }

            /* --- STYLING NAVBAR IDENTIK --- */
            .navbar-custom {
                background-color: var(--teal-bintang);
                padding: 1.25rem 2rem;
            }

            .nav-brand {
                color: white;
                font-weight: 800;
                font-size: 1.25rem;
                letter-spacing: 0.05em;
                text-transform: uppercase;
            }

            /* Link Menu: Teks selalu putih */
            .nav-link-custom {
                color: white !important; /* Memaksa teks tetap putih */
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.15em;
                position: relative;
                padding-bottom: 4px;
                transition: all 0.3s ease;
                opacity: 0.8;
            }

            /* Saat Hover atau Aktif: Tetap putih, tapi opacity penuh & ada garis bawah emas */
            .nav-link-custom:hover,
            .nav-link-custom.active {
                opacity: 1;
                border-bottom: 2px solid var(--gold-bintang);
            }

            /* Button Keluar: Sesuai screenshot yang ada border putih tipis */
            .btn-keluar {
                border: 1px solid rgba(255, 255, 255, 0.4);
                color: white;
                padding: 0.6rem 1.5rem;
                border-radius: 0.8rem;
                font-size: 10px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                transition: all 0.3s;
            }
            .btn-keluar:hover {
                background-color: rgba(255, 255, 255, 0.1);
                border-color: white;
            }

            /* --- KOMPONEN LAINNYA --- */
            .input-bintang {
                background-color: white;
                border: 2px solid transparent;
                transition: all 0.3s ease;
            }
            .input-bintang:focus {
                border-color: var(--gold-bintang);
                box-shadow: 0 0 15px rgba(197, 163, 103, 0.1);
                outline: none;
            }

            .card-bintang {
                transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
            }
            .card-bintang:hover {
                transform: translateY(-12px);
                box-shadow: 0 25px 50px rgba(44, 78, 88, 0.15);
            }

            .fade-in {
                animation: fadeIn 0.8s ease forwards;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen">

          @include('layouts.navigation')

            <div class="max-w-7xl mx-auto p-4 md:p-6 lg:p-8 w-full fade-in">

                {{-- HEADER JUDUL --}}
                <div class="text-center mb-12 mt-8">
                    <h1 class="text-3xl md:text-5xl font-black text-[var(--teal-bintang)] tracking-tighter uppercase mb-2">Portal Booking Mitra</h1>
                    <div class="h-1.5 w-20 bg-[var(--gold-bintang)] mx-auto mb-4 rounded-full"></div>
                    <p class="text-[var(--gold-bintang)] font-bold italic uppercase tracking-[0.3em] text-[10px] md:text-xs">Layanan Eksklusif B2B Bintang Global</p>
                </div>

                {{-- FILTER --}}
                <div class="mb-12 bg-white/60 p-6 rounded-[2.5rem] backdrop-blur-md border border-white shadow-sm">
                    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col lg:flex-row gap-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:flex gap-4 flex-grow">
                            <select name="category" onchange="this.form.submit()"
                                    class="w-full lg:w-64 px-4 py-3 rounded-2xl input-bintang text-sm font-bold text-[var(--teal-bintang)] shadow-sm cursor-pointer">
                                <option value="">Semua Layanan</option>
                                <option value="umroh_full" {{ request('category') == 'umroh_full' ? 'selected' : '' }}>Paket Umroh</option>
                                <option value="hotel_only" {{ request('category') == 'hotel_only' ? 'selected' : '' }}>Wholesale Hotel</option>
                                <option value="transport_only" {{ request('category') == 'transport_only' ? 'selected' : '' }}>Bus & Transport</option>
                            </select>

                            <div class="relative flex-grow">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama paket, hotel, atau armada..."
                                    class="w-full pl-12 pr-4 py-3 rounded-2xl input-bintang text-sm font-bold text-[var(--teal-bintang)] shadow-sm">
                            </div>

                            <select name="currency" onchange="this.form.submit()"
                                    class="w-full lg:w-48 px-4 py-3 rounded-2xl input-bintang text-sm font-bold text-[var(--teal-bintang)] shadow-sm cursor-pointer">
                                <option value="">Semua Kurs</option>
                                <option value="SAR" {{ request('currency') == 'SAR' ? 'selected' : '' }}>SAR (Riyal)</option>
                                <option value="IDR" {{ request('currency') == 'IDR' ? 'selected' : '' }}>IDR (Rupiah)</option>
                                <option value="USD" {{ request('currency') == 'USD' ? 'selected' : '' }}>USD (Dollar)</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-[var(--teal-bintang)] text-white px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-black transition shadow-lg">Filter</button>
                    </form>
                </div>

                {{-- GRID PAKET --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($packages as $p)
                    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-md card-bintang flex flex-col border border-gray-100">
                        <div class="relative h-[400px] bg-gray-50 flex items-center justify-center p-4">
                            @if($p->image)
                                <img src="{{ asset('uploads/packages/' . $p->image) }}"
                                     class="max-w-full max-h-full object-contain drop-shadow-md rounded-xl"
                                     alt="{{ $p->nama_paket }}">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300 font-bold uppercase text-[10px] tracking-widest">No Image</div>
                            @endif

                            <div class="absolute top-4 left-4">
                                <span class="px-4 py-1.5 {{ Str::contains(strtolower($p->category), 'umroh') ? 'bg-blue-600' : (Str::contains(strtolower($p->category), 'transport') ? 'bg-purple-600' : 'bg-[#C5A367]') }} text-white text-[9px] font-black uppercase tracking-widest rounded-full shadow-lg">
                                    {{ str_replace('_', ' ', $p->category) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-8 flex flex-col flex-grow">
                            <h3 class="text-xl font-black uppercase leading-tight mb-3 min-h-[3rem] text-[var(--teal-bintang)]">{{ $p->nama_paket }}</h3>
                            <p class="text-gray-500 text-xs mb-6 line-clamp-2 italic leading-relaxed">{{ strip_tags($p->deskripsi) }}</p>

                            <div class="mt-auto grid grid-cols-2 gap-4 pt-6 border-t border-gray-50">
                                <div>
                                    <div class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Harga Nett</div>
                                    <div class="text-lg font-black text-[#166534]">{{ $p->currency }} {{ number_format($p->harga_agen, 0, ',', '.') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mb-1">Sisa Kursi</div>
                                    <div class="text-lg font-black">{{ $p->sisa_kuota }}<span class="text-[10px] text-gray-300">/{{ $p->kuota_awal }}</span></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mt-6">
                                <a href="{{ route('user.booking.show', $p->id) }}"
                                   class="bg-[var(--bg-krem)] text-[var(--teal-bintang)] text-center font-black py-3 rounded-xl uppercase text-[10px] tracking-widest hover:bg-[var(--gold-bintang)] hover:text-white transition-all">
                                    Detail
                                </a>
                                <a href="{{ route('booking.pendaftaran', $p->id) }}"
                                   class="bg-[var(--teal-bintang)] text-white text-center font-black py-3 rounded-xl uppercase text-[10px] tracking-widest hover:bg-black transition-all shadow-lg active:scale-95">
                                    Booking
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-32 text-center">
                        <div class="text-6xl mb-4">📂</div>
                        <p class="text-gray-400 font-black uppercase text-sm tracking-[0.5em]">Belum Ada Layanan Tersedia</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @include('layouts.footer-bintang')
    </body>
</html>
