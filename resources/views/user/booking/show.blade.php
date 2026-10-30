<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Paket - {{ $package->nama_paket }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
    <style>
        :root {
            --teal-bintang: #2C4E58;
            --gold-bintang: #C5A367;
            --bg-krem: #F9F7F2;
        }
        body { background-color: var(--bg-krem); font-family: 'Figtree', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="antialiased p-4 md:p-12">

    <div class="max-w-6xl mx-auto">
        {{-- Tombol Kembali --}}
        <a href="{{ Auth::check() ? route('dashboard') : route('home') }}"
            class="inline-flex items-center gap-2 text-[var(--teal-bintang)] font-bold text-sm mb-8 no-underline hover:translate-x-[-5px] transition-transform">
             <span class="bg-[var(--teal-bintang)] text-white w-6 h-6 flex items-center justify-center rounded-full text-xs">←</span>
             Kembali ke Daftar Paket
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- SISI KIRI: POSTER --}}
            <div class="relative group cursor-zoom-in" onclick="openModal()">
                @if($package->image)
                    <img src="{{ asset('uploads/packages/' . $package->image) }}"
                         class="w-full rounded-[2.5rem] shadow-2xl border-4 border-white transition transform group-hover:rotate-1"
                         id="posterUtama">
                @else
                    <div class="w-full h-[500px] bg-gray-200 rounded-[2.5rem] flex items-center justify-center text-gray-400 font-bold uppercase tracking-widest">
                        Gambar Tidak Tersedia
                    </div>
                @endif
                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition rounded-[2.5rem] flex items-center justify-center">
                    <span class="bg-white/90 text-[var(--teal-bintang)] px-8 py-3 rounded-full font-black uppercase text-xs tracking-widest shadow-xl">
                        🔍 Perbesar Poster
                    </span>
                </div>
            </div>

            {{-- SISI KANAN: DETAIL & HARGA --}}
            <div class="flex flex-col">
                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-[var(--gold-bintang)]/10 text-[var(--gold-bintang)] px-4 py-1 rounded-full font-black uppercase tracking-widest text-[9px]">
                        Land Arrangement
                    </span>
                    <span class="bg-gray-100 text-gray-400 px-4 py-1 rounded-full font-black uppercase tracking-widest text-[9px]">
                        B2B Partner Only
                    </span>
                </div>

                <h1 class="text-5xl font-black text-[var(--teal-bintang)] uppercase leading-[1.1] mb-6 tracking-tighter">
                    {{ $package->nama_paket }}
                </h1>

                <div class="h-1.5 w-24 bg-[var(--gold-bintang)] mb-8 rounded-full"></div>

                <div class="prose prose-slate mb-10 text-gray-500 leading-relaxed text-lg">
                    {!! $package->deskripsi ?? 'Nikmati fasilitas terbaik dari Bintang Global Wisata untuk kenyamanan ibadah Anda.' !!}
                </div>

                {{-- CARD HARGA & KONVERSI --}}
                <div class="bg-white p-10 rounded-[3rem] shadow-[0_40px_80px_rgba(44,78,88,0.12)] border-t-[12px] border-[var(--teal-bintang)] relative overflow-hidden">
                    {{-- Dekorasi background --}}
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-[var(--bg-krem)] rounded-full opacity-50"></div>

                    <div class="flex justify-between items-center mb-8 relative z-10">
                        <p class="text-[11px] text-gray-400 font-black uppercase tracking-[0.3em]">Nett Per Pax</p>
                        <div class="px-4 py-1.5 bg-orange-50 border border-orange-100 rounded-full text-orange-600 font-black text-[10px] animate-pulse">
                            SISA: {{ $package->sisa_kuota }} SEAT
                        </div>
                    </div>

                    <div class="space-y-6 relative z-10">
                        {{-- Harga Asli --}}
                        <div class="flex items-baseline gap-3">
                            <span class="text-3xl font-black text-[var(--gold-bintang)]">{{ $package->currency }}</span>
                            <span class="text-7xl font-black text-[var(--teal-bintang)] tracking-tighter">
                                {{ number_format($package->harga_agen, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- Section Estimasi Rupiah --}}
                        @if($package->currency != 'IDR')
                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-dashed border-gray-200"></div></div>
                            <div class="relative flex justify-center">
                                <span class="bg-white px-4 text-gray-300 text-[10px] font-bold uppercase tracking-[0.2em]">Konversi ke Rupiah</span>
                            </div>
                        </div>

                        <div class="bg-emerald-50 p-8 rounded-[2rem] border-2 border-emerald-100/50 group">
                            <div class="text-sm text-emerald-600 font-bold uppercase mb-1 opacity-70">Estimasi Pembayaran</div>
                            <div class="text-5xl font-black text-emerald-800 tracking-tight">
                                @php
                                    $currentRate = $rates[$package->currency] ?? 1;
                                    $totalIdr = $package->harga_agen * $currentRate;
                                @endphp
                                Rp {{ number_format($totalIdr, 0, ',', '.') }}
                            </div>
                            <div class="flex items-center gap-2 mt-4 pt-4 border-t border-emerald-100">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                <p class="text-[10px] text-emerald-600 font-black uppercase tracking-wider">
                                    Kurs Kantor Hari Ini: 1 {{ $package->currency }} = Rp {{ number_format($currentRate, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <a href="{{ route('booking.pendaftaran', $package->id) }}" class="block w-full text-center mt-10 bg-[var(--teal-bintang)] hover:bg-black text-white font-black py-6 rounded-2xl uppercase tracking-[0.2em] text-sm transition-all shadow-xl hover:shadow-2xl active:scale-95 no-underline">
                        Booking Sekarang
                    </a>

                    <p class="text-center mt-8 text-[9px] text-gray-400 font-bold uppercase tracking-widest opacity-60">
                        Harga dapat berubah mengikuti fluktuasi kurs • PT Bintang Global Wisata
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PREVIEW POSTER --}}
    <div id="posterModal" class="fixed inset-0 z-[100] hidden bg-black/95 flex items-center justify-center p-6 backdrop-blur-md transition-all duration-300" onclick="closeModal()">
        <img id="modalImg" src="{{ asset('uploads/packages/' . $package->image) }}" class="max-h-[90vh] rounded-xl shadow-2xl transition-all duration-500 scale-90 border-2 border-white/20">
        <button class="absolute top-8 right-8 text-white/50 hover:text-white text-5xl font-light transition">&times;</button>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('posterModal');
            const img = document.getElementById('modalImg');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => { img.classList.remove('scale-90'); img.classList.add('scale-100'); }, 10);
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            const modal = document.getElementById('posterModal');
            const img = document.getElementById('modalImg');
            img.classList.add('scale-90');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
            document.body.style.overflow = 'auto';
        }
    </script>
</body>
</html>
