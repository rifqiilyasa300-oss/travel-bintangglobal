<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Portal Admin - Bintang Global</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            :root {
                --teal-bintang: #2C4E58;
                --gold-bintang: #C5A367;
                --bg-krem: #F9F7F2;
            }
            body {
                background-color: var(--bg-krem);
                font-family: 'Figtree', sans-serif;
                color: var(--teal-bintang);
            }
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .card-admin {
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }
            .card-admin:hover {
                transform: translateY(-10px);
                box-shadow: 0 25px 50px -12px rgba(44, 78, 88, 0.15);
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen">

            @include('layouts.navigation')

            <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full">

                {{-- HEADER SECTION --}}
                <div class="text-center mb-12 mt-8">
                    <h1 class="text-5xl font-extrabold text-[var(--teal-bintang)] tracking-tighter uppercase mb-2">Portal Admin Bintang Global</h1>
                    <div class="h-1.5 w-32 bg-[var(--gold-bintang)] mx-auto mb-4 rounded-full"></div>
                    <p class="text-[var(--gold-bintang)] font-bold italic uppercase tracking-[0.3em] text-xs">Sistem Kelola & Laporan Pemasukan</p>
                </div>

                {{-- STATISTIK PEMASUKAN --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
                    @foreach($incomeByCurrency as $income)
                        @if($income->currency !== 'USD')
                        <a href="{{ route('admin.riwayat', ['currency' => $income->currency]) }}" class="block transition hover:scale-105 no-underline">
                            <div class="bg-white p-5 rounded-[1.5rem] border-l-8 border-[var(--gold-bintang)] shadow-[0_10px_30px_rgba(0,0,0,0.05)] h-full">
                                <p class="text-[var(--teal-bintang)]/50 text-[9px] font-black uppercase tracking-widest mb-1">Kas {{ $income->currency }}</p>
                                <h3 class="text-lg font-black text-[var(--teal-bintang)]">
                                    {{ $income->currency == 'IDR' ? 'Rp' : 'SAR' }} {{ number_format($income->total_nilai, 0, ',', '.') }}
                                </h3>
                                <p class="text-[8px] text-blue-500 font-bold mt-2 uppercase">
                                    {{ $income->total_transaksi }} Transaksi →
                                </p>
                            </div>
                        </a>
                        @endif
                    @endforeach

                    <div class="bg-white p-5 rounded-[1.5rem] border-l-8 border-orange-400 shadow-[0_10px_30px_rgba(0,0,0,0.05)]">
                        <p class="text-orange-400/60 text-[9px] font-black uppercase tracking-widest mb-1">Wholesale Hotel</p>
                        <h3 class="text-lg font-black text-[var(--teal-bintang)]">Rp {{ number_format($incomeHotel ?? 0, 0, ',', '.') }}</h3>
                        <p class="text-[8px] text-gray-400 font-bold mt-2 uppercase">Booking Eceran</p>
                    </div>

                    <div class="bg-[var(--teal-bintang)] p-5 rounded-[1.5rem] shadow-[0_20px_40px_rgba(44,78,88,0.3)]">
                        <p class="text-[var(--gold-bintang)] text-[9px] font-black uppercase tracking-widest mb-1">Grand Total (IDR)</p>
                        <h3 class="text-lg font-black text-white">Rp {{ number_format($grandTotalIDR, 0, ',', '.') }}</h3>
                    </div>
                </div>

                {{-- FORM UPDATE KURS --}}
                <div class="mb-10 bg-white p-8 rounded-[2rem] shadow-[0_15px_40px_rgba(0,0,0,0.03)] border border-gray-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-[var(--bg-krem)] rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--gold-bintang)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-black text-[var(--teal-bintang)] uppercase tracking-tight">Update Kurs Mata Uang</h2>
                    </div>

                    <form action="{{ route('admin.rates.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-black text-[var(--teal-bintang)]/40 uppercase tracking-widest mb-2 ml-1">Mata Uang</label>
                            <select name="currency" class="w-full bg-[var(--bg-krem)] border-none rounded-xl px-4 py-3 text-sm font-bold text-[var(--teal-bintang)] focus:ring-2 focus:ring-[var(--gold-bintang)] transition">
                                <option value="SAR">SAR (Saudi Riyal)</option>
                                <option value="IDR">IDR (Indonesian Rupiah)</option>
                                <option value="USD">USD (US Dollar)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-[var(--teal-bintang)]/40 uppercase tracking-widest mb-2 ml-1">Nilai Kurs ke IDR</label>
                            <input type="number" step="0.01" name="rate" placeholder="Contoh: 4522.16" required
                                   class="w-full bg-[var(--bg-krem)] border-none rounded-xl px-4 py-3 text-sm font-bold text-[var(--teal-bintang)] focus:ring-2 focus:ring-[var(--gold-bintang)] transition">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-[var(--gold-bintang)] hover:bg-[var(--teal-bintang)] text-white font-black py-3.5 rounded-xl text-[10px] uppercase tracking-[0.2em] transition duration-300 shadow-lg shadow-[var(--gold-bintang)]/20 active:scale-95">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- SECTION HEADER DAFTAR PAKET --}}
                <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                    <div>
                        <h2 class="text-3xl font-extrabold text-[var(--teal-bintang)] uppercase tracking-tight">Manajemen Paket</h2>
                        <p class="text-[var(--gold-bintang)] text-[10px] font-bold uppercase tracking-widest">Atur ketersediaan dan harga layanan</p>
                    </div>

                    <a href="{{ route('admin.packages.create') }}"
                       class="bg-[var(--teal-bintang)] hover:bg-black text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition duration-300 shadow-[0_10px_20px_rgba(44,78,88,0.2)] flex items-center gap-3 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--gold-bintang)]" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Buat Paket Baru
                    </a>
                </div>

                {{-- GRID CARD PAKET (SYNCED STYLE) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($packages as $p)
                    <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-md border border-gray-100 flex flex-col card-admin group">

                        {{-- Image Header - FIX: Sync with Welcome Page --}}
                        <div class="relative h-[400px] bg-gray-50 flex items-center justify-center p-4 overflow-hidden">
                            @if($p->image)
                                <img src="{{ asset('uploads/packages/' . $p->image) }}"
                                     class="max-w-full max-h-full object-contain drop-shadow-md rounded-xl transition duration-500 group-hover:scale-105"
                                     alt="{{ $p->nama_paket }}">
                            @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-300 font-bold uppercase text-[10px] tracking-widest">No Image</div>
                            @endif

                            {{-- Badge Kategori --}}
                            <div class="absolute top-5 left-5">
                                <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest shadow-lg
                                    @if($p->category == 'hotel_only') bg-emerald-500 text-white
                                    @elseif($p->category == 'transport_only') bg-purple-600 text-white
                                    @else bg-blue-600 text-white @endif">
                                    {{ str_replace('_', ' ', $p->category) }}
                                </span>
                            </div>

                            {{-- Quick Preview Modal Trigger --}}
                            <button onclick="openPreview('{{ asset('uploads/packages/' . $p->image) }}', '{{ $p->nama_paket }}')"
                                    class="absolute bottom-5 right-5 bg-white/80 backdrop-blur-md text-[var(--teal-bintang)] p-3 rounded-full hover:bg-[var(--gold-bintang)] hover:text-white transition duration-300 shadow-xl opacity-0 group-hover:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </button>
                        </div>

                        {{-- Content --}}
                        <div class="p-8 flex flex-col flex-grow">
                            <h3 class="text-xl font-black text-[var(--teal-bintang)] uppercase leading-tight tracking-tighter mb-4 min-h-[3rem]">{{ $p->nama_paket }}</h3>

                            <p class="text-gray-500 text-xs italic line-clamp-2 mb-6 flex-grow leading-relaxed">
                                {{ strip_tags($p->deskripsi) ?? 'Ready Stock.' }}
                            </p>

                            <div class="flex items-center justify-between bg-[var(--bg-krem)] p-4 rounded-2xl mb-6">
                                <div>
                                    <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Sisa Kuota</p>
                                    <p class="text-sm font-black text-[var(--teal-bintang)]">{{ $p->sisa_kuota ?? 0 }} <span class="text-[10px] text-gray-300">/ {{ $p->kuota_awal ?? 0 }}</span></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Harga Agen</p>
                                    <p class="text-lg font-black text-[#166534]">{{ $p->currency }} {{ number_format($p->harga_agen, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('admin.packages.edit', $p->id) }}"
                                   class="bg-[var(--teal-bintang)] hover:bg-black text-white text-center font-black py-3 rounded-xl uppercase text-[10px] tracking-widest transition shadow-lg active:scale-95">
                                    Edit Data
                                </a>
                                <form action="{{ route('admin.packages.destroy', $p->id) }}" method="POST" class="w-full">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus paket ini?')"
                                            class="w-full bg-red-50 hover:bg-red-600 hover:text-white text-red-600 font-black py-3 rounded-xl uppercase text-[10px] tracking-widest transition active:scale-95">
                                       Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full p-20 text-center bg-white rounded-[3rem] border-4 border-dashed border-gray-100">
                        <p class="text-gray-300 font-black uppercase text-xs tracking-[0.5em]">Belum Ada Layanan Aktif</p>
                    </div>
                    @endforelse
                </div>

                {{-- FOOTER --}}
                <div class="mt-20 text-center pb-12 opacity-30">
                    <p class="text-[10px] text-[var(--teal-bintang)] font-black uppercase tracking-[0.8em]">PT Bintang Global Wisata &copy; 2026</p>
                </div>
            </div>

            {{-- MODAL PREVIEW GAMBAR --}}
            <div id="imageModal" class="fixed inset-0 z-[999] hidden bg-black/95 backdrop-blur-md flex items-center justify-center p-6">
                <button onclick="closePreview()" class="absolute top-10 right-10 text-white/70 hover:text-white text-6xl font-light transition active:scale-95">&times;</button>
                <div class="max-w-4xl w-full flex flex-col items-center">
                    <div class="rounded-lg overflow-hidden shadow-2xl">
                        <img id="modalImg" src="" class="max-w-full max-h-[75vh] object-contain">
                    </div>
                    <div class="w-full text-center mt-8">
                        <h3 id="modalTitle" class="text-2xl font-black text-white uppercase tracking-widest"></h3>
                        <div class="h-1 w-24 bg-[var(--gold-bintang)] mx-auto mt-4 rounded-full"></div>
                    </div>
                </div>
            </div>

        </div>

        <script>
            function openPreview(imgSrc, title) {
                const modal = document.getElementById('imageModal');
                const modalImg = document.getElementById('modalImg');
                const modalTitle = document.getElementById('modalTitle');
                modalImg.src = imgSrc;
                modalTitle.innerText = title;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
            function closePreview() {
                const modal = document.getElementById('imageModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
            window.onclick = function(event) {
                const modal = document.getElementById('imageModal');
                if (event.target == modal) { closePreview(); }
            }
        </script>
        @include('layouts.footer-bintang')
    </body>
</html>
