<x-app-layout>
    <div class="max-w-7xl mx-auto py-12 px-6">
        <h2 class="text-3xl font-black text-[#2C4E58] mb-8 flex items-center gap-3">
            <span class="text-4xl">📩</span> Pesan Masuk (Kontak)
        </h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl mb-6 shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($pesans->isEmpty())
            <div class="bg-white rounded-3xl p-20 text-center shadow-sm border border-dashed border-gray-300">
                <div class="text-6xl mb-4">📭</div>
                <h3 class="text-xl font-bold text-gray-400">Belum ada pesan masuk dari user.</h3>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($pesans as $pesan)
                    <div class="bg-white p-6 rounded-3xl shadow-xl border-l-8 border-[#C5A367] hover:scale-[1.02] transition-transform duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4 class="text-lg font-extrabold text-[#2C4E58]">{{ $pesan->nama_pengirim }}</h4>
                                <p class="text-sm text-[#C5A367] font-semibold">{{ $pesan->email_wa }}</p>
                            </div>
                            <span class="text-[10px] bg-gray-100 px-3 py-1 rounded-full text-gray-500 font-bold">
                                {{ $pesan->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            <p class="text-gray-600 text-sm leading-relaxed italic">
                                "{{ $pesan->pesan }}"
                            </p>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <form action="{{ route('admin.kontak.destroy', $pesan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold flex items-center gap-1 transition-colors">
                                    🗑️ Hapus Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
