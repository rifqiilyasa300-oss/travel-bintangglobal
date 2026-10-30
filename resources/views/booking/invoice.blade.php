<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #INV-{{ $booking->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&family=Gentium+Plus:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FDFBF7; -webkit-font-smoothing: antialiased; }
        .font-gentium { font-family: 'Gentium Plus', serif; }
        @media print {
            .no-print { display: none !important; }
            body { background-color: white; padding: 0; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #eee !important; }
        }
        .watermark-paid {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem; font-weight: 900; color: rgba(34, 197, 94, 0.08);
            pointer-events: none; text-transform: uppercase; z-index: 0;
        }
    </style>
</head>
<body class="p-4 md:p-12 relative">

    {{-- Tombol Navigasi --}}
    <div class="max-w-5xl mx-auto mb-8 flex justify-between items-center no-print px-4 md:px-0">
        <a href="{{ route('riwayat') }}" class="flex items-center gap-3 text-[#2C4E58] font-bold text-[11px] uppercase tracking-widest hover:text-[#C5A367] transition-all group">
            <div class="p-2 bg-white rounded-full shadow-sm group-hover:shadow-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            Kembali ke Riwayat
        </a>
        <button onclick="window.print()" class="bg-[#2C4E58] text-white px-10 py-3 rounded-full font-bold text-[11px] uppercase tracking-[0.2em] shadow-xl hover:bg-[#1a3138] transform hover:-translate-y-0.5 transition-all active:scale-95 cursor-pointer">
            Cetak Invoice
        </button>
    </div>

    <div class="max-w-5xl mx-auto bg-white shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] rounded-[2.5rem] overflow-hidden border border-gray-100 relative print-shadow-none">

        {{-- Logika Sisa & Watermark --}}
        @php
            $totalDibayar = $booking->payments->where('status', 'success')->sum('amount_paid');
            $sisa = $booking->total_tagihan - $totalDibayar;
        @endphp

        @if($sisa <= 0 && $totalDibayar > 0)
            <div class="watermark-paid">PAID</div>
        @endif

        <div class="h-3 w-full bg-gradient-to-r from-[#2C4E58] via-[#C5A367] to-[#2C4E58]"></div>

        <div class="p-10 md:p-16 flex flex-col md:flex-row justify-between items-start">
            <div class="relative z-10">
                <div class="bg-[#2C4E58] inline-block px-4 py-1 rounded-lg mb-4">
                    <span class="text-white text-[10px] font-black uppercase tracking-[0.4em]">Official Invoice</span>
                </div>

                <h2 class="text-[#C5A367] font-bold text-xl uppercase tracking-[0.2em] mb-2">PT Bintang Global Wisata</h2>
                <div class="space-y-1 text-[11px] text-gray-500 font-semibold leading-relaxed uppercase tracking-wider mb-8">
                    <p>Jl. Raya Condet No.8a, RT.5/RW.3, Balekambang,<br>
                    Kec. Kramat jati, Kota Jakarta Timur, DKI Jakarta 13530</p>
                    <p>Telp: 0858-5058-1030</p>
                </div>

                <div class="pt-6 border-t border-gray-100">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Tagihan Kepada:</span>
                    <h1 class="text-3xl font-black text-[#2C4E58] uppercase tracking-tighter leading-none mb-1">{{ $booking->nama_group ?? 'Jamaah Umroh' }}</h1>
                    <p class="text-[10px] text-[#C5A367] font-bold uppercase tracking-[0.3em]">Jamaah / Group Member</p>
                </div>
            </div>

            <div class="mt-10 md:mt-0">
                <div class="bg-gray-50 p-8 rounded-[2rem] border border-gray-100 flex flex-col items-end shadow-sm">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Nomor Invoice</span>
                    <span class="text-2xl font-black text-[#2C4E58] mb-6">#INV-{{ $booking->id }}{{ $booking->created_at->format('Ymd') }}</span>

                    <div class="text-right">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 block">Tanggal Terbit</span>
                        <span class="text-sm font-bold text-gray-700">{{ $booking->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-10 md:px-16 pb-10">
            {{-- Tabel Rincian --}}
            <div class="overflow-hidden rounded-2xl border border-gray-100 shadow-sm mb-12">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr class="text-[10px] font-black text-[#2C4E58] uppercase tracking-[0.2em]">
                            <th class="px-8 py-5">Rincian Pemesanan</th>
                            <th class="px-8 py-5 text-center">QTY</th>
                            <th class="px-8 py-5 text-right">Harga Satuan</th>
                            <th class="px-8 py-5 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($booking->details as $detail)
                        <tr>
                            <td class="px-8 py-6 align-top font-black text-[#2C4E58] text-lg uppercase tracking-tight">
                                {{ $detail->nama_layanan }}
                            </td>
                            <td class="px-8 py-6 text-center align-top font-bold text-gray-600">{{ $detail->qty }}</td>
                            <td class="px-8 py-6 text-right align-top font-medium text-gray-500">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="px-8 py-6 text-right align-top whitespace-nowrap font-black text-[#2C4E58] italic font-gentium text-xl">
                                Rp {{ number_format($detail->qty * $detail->harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                {{-- Riwayat Pembayaran --}}
                <div>
                    <h3 class="text-[10px] font-black text-[#C5A367] uppercase tracking-[0.3em] mb-4">Riwayat Pembayaran</h3>
                    <div class="space-y-3">
                        @forelse($booking->payments as $payment)
                        <div class="flex items-center justify-between p-4 rounded-xl border border-gray-50 bg-[#FDFBF7]/50">
                            <div>
                                <span class="text-[9px] font-black text-gray-400 uppercase">{{ $payment->created_at->format('d/m/Y') }}</span>
                                <p class="text-xs font-bold text-[#2C4E58] uppercase">{{ $payment->payment_method ?? 'Transfer' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-black text-gray-800">Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}</p>
                                <span class="text-[9px] font-black uppercase {{ $payment->status == 'success' ? 'text-green-500' : 'text-orange-500' }}">
                                    {{ $payment->status }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-xs italic text-gray-400">Belum ada catatan pembayaran.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Kotak Total --}}
                <div class="bg-[#2C4E58] rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden">
                    <div class="relative z-10 space-y-4">
                        <div class="flex justify-between border-b border-white/10 pb-2">
                            <span class="text-[10px] font-bold uppercase text-[#C5A367]">Total Tagihan</span>
                            <span class="font-bold">Rp {{ number_format($booking->total_tagihan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-b border-white/10 pb-2">
                            <span class="text-[10px] font-bold uppercase text-green-400">Total Dibayar</span>
                            <span class="font-bold">Rp {{ number_format($totalDibayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-2">
                            <span class="text-[10px] font-black uppercase text-[#C5A367] block mb-1">Sisa Pembayaran</span>
                            <div class="text-4xl font-black font-gentium italic">
                                Rp {{ number_format($sisa, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Instruksi Pembayaran DINAMIS --}}
        <div class="bg-gray-50 p-10 md:p-16 border-t border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="w-full md:w-2/3">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Informasi Rekening Pembayaran:</p>

                    {{-- Ganti bagian ini di file invoice.blade.php kamu --}}
<div class="flex flex-wrap gap-4">
    @php
        // Sesuaikan dengan nama kolom di screenshot database kamu: 'metode_bayar'
        $metode = strtoupper($booking->metode_bayar);
    @endphp

    @if($metode == 'BSI')
        <div class="bg-white p-5 pr-10 rounded-2xl border-2 border-[#C5A367] shadow-sm">
            <p class="text-[10px] font-black text-[#C5A367] uppercase mb-1">Bank Syariah Indonesia (BSI)</p>
            <p class="text-2xl font-black text-[#2C4E58] tracking-widest">727 680 8202</p>
        </div>
    @elseif($metode == 'BNI')
        <div class="bg-white p-5 pr-10 rounded-2xl border-2 border-[#C5A367] shadow-sm">
            <p class="text-[10px] font-black text-[#C5A367] uppercase mb-1">Bank BNI</p>
            <p class="text-2xl font-black text-[#2C4E58] tracking-widest">1929941719</p>
        </div>
    @elseif($metode == 'BRI')
        <div class="bg-white p-5 pr-10 rounded-2xl border-2 border-[#C5A367] shadow-sm">
            <p class="text-[10px] font-black text-[#C5A367] uppercase mb-1">Bank BRI</p>
            <p class="text-2xl font-black text-[#2C4E58] tracking-widest">173901000308305</p>
        </div>
    @else
        <p class="text-sm font-bold text-[#2C4E58] italic">
            Silakan hubungi admin untuk detail pembayaran.
        </p>
    @endif
</div>

                    <p class="text-[10px] mt-4 font-bold text-gray-400 uppercase tracking-widest italic">
                        * Seluruh Rekening Atas Nama <span class="text-[#2C4E58] not-italic">PT BINTANG GLOBAL WISATA</span>
                    </p>
                </div>
                <div class="text-center md:text-right">
                    <p class="font-gentium text-2xl italic text-[#2C4E58] mb-2">"Semoga menjadi Umroh yang Mabrur"</p>
                    <p class="text-[9px] font-black text-gray-300 uppercase tracking-[0.8em]">BINTANG GLOBAL WISATA</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer No-Print --}}
    <div class="max-w-5xl mx-auto mt-8 text-center no-print">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Invoice ini dihasilkan secara otomatis oleh sistem</p>
    </div>

</body>
</html>
