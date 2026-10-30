<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="relative bg-[#2C4E58] py-16 px-6 text-center text-white">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="relative z-10">
            <h1 class="text-4xl font-extrabold mb-2 uppercase tracking-wide">Panel Kelola Kantor</h1>
            <p class="text-gray-200">Mode Administrator: Update data jaringan Bintang Global secara real-time.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-12 px-6">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl mb-6 shadow-sm flex items-center gap-3">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <div class="mb-16">
            <h2 class="text-2xl font-bold text-[#2C4E58] mb-6 flex items-center gap-2">
                <span class="p-2 bg-[#2C4E58] text-white rounded-lg">🏢</span> Kantor Pusat (Headquarters)
            </h2>
            <div class="bg-gradient-to-r from-[#2C4E58] to-[#3d6b78] rounded-3xl p-8 text-white shadow-xl flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h3 class="text-3xl font-black mb-2">Bintang Global (BG) - Mekah</h3>
                    <p class="text-gray-200 italic">Alamat: Ibrahim Al Khalil Road, Makkah, Saudi Arabia</p>
                </div>
                <div class="mt-6 md:mt-0 bg-white/20 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/30 text-center">
                    <span class="block text-sm uppercase tracking-widest">Status</span>
                    <span class="text-xl font-bold">OPERASIONAL PUSAT</span>
                </div>
            </div>
        </div>

        <div>
            <div class="flex justify-between items-center mb-10">
                <h2 class="text-2xl font-bold text-[#2C4E58] flex items-center gap-2">
                    <span class="p-2 bg-[#C5A367] text-white rounded-xl shadow-sm">📍</span> Jaringan Distribusi
                </h2>
                <button onclick="openModalTambah()" class="bg-[#2C4E58] hover:bg-[#3d6b78] text-white px-6 py-2 rounded-xl font-bold transition shadow-lg transform hover:scale-105">
                    + Tambah Cabang
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($cabangs as $cabang)
                <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 flex flex-col justify-between hover:shadow-2xl transition duration-300 relative group">

                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-xl font-extrabold text-[#2C4E58]">{{ $cabang->nama_cabang }}</h4>
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-4 py-1.5 rounded-full">Aktif</span>
                        </div>
                        <p class="text-sm text-gray-500 flex items-center gap-2 mb-6">
                            📍 {{ $cabang->lokasi }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-5 flex items-center justify-between border border-gray-100 transition shadow-inner">
                        <span class="text-gray-600 font-semibold">Total Agen</span>
                        <span class="text-3xl font-black text-[#C5A367]">{{ $cabang->total_agen }}</span>
                    </div>

                    <div class="mt-5 flex gap-2">
                        <button onclick="openModalEdit({{ json_encode($cabang) }})"
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2.5 rounded-xl text-sm font-bold shadow-md flex justify-center items-center gap-2 transition">
                            ✏️ Edit
                        </button>

                        <form action="{{ route('admin.cabang.destroy', $cabang->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus cabang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2.5 rounded-xl text-sm font-bold shadow-md flex justify-center items-center gap-2 transition">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="modalCabang" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeModal()"></div>

            <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-md w-full p-10 transition-all transform scale-100 border border-gray-100">
                <div class="flex justify-between items-center mb-8">
                    <h3 id="modalTitle" class="text-2xl font-black text-[#2C4E58]">📍 Tambah Cabang</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 text-3xl">&times;</button>
                </div>

                <form id="formCabang" action="{{ route('admin.cabang.store') }}" method="POST">
                    @csrf
                    <div id="methodField"></div>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-bold text-[#2C4E58] mb-2 uppercase tracking-wide">Nama Cabang</label>
                            <input type="text" name="nama_cabang" id="in_nama" class="w-full rounded-xl border-gray-200 focus:border-[#C5A367] focus:ring-[#C5A367] py-3" placeholder="Misal: Cabang Jakarta" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#2C4E58] mb-2 uppercase tracking-wide">Lokasi / Alamat</label>
                            <input type="text" name="lokasi" id="in_lokasi" class="w-full rounded-xl border-gray-200 focus:border-[#C5A367] focus:ring-[#C5A367] py-3" placeholder="Alamat singkat kota" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#2C4E58] mb-2 uppercase tracking-wide">Jumlah Agen</label>
                            <input type="number" name="total_agen" id="in_agen" class="w-full rounded-xl border-gray-200 focus:border-[#C5A367] focus:ring-[#C5A367] py-3" value="0">
                        </div>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <button type="button" onclick="closeModal()" class="flex-1 py-3 border border-gray-200 rounded-xl font-bold text-gray-400 hover:bg-gray-50 transition">Batal</button>
                        <button type="submit" class="flex-1 py-3 bg-[#2C4E58] text-white rounded-xl font-bold hover:bg-[#3d6b78] shadow-lg transition">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalCabang');
        const form = document.getElementById('formCabang');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');

        function openModalTambah() {
            modal.classList.remove('hidden');
            modalTitle.innerText = "📍 Tambah Cabang Baru";
            form.action = "{{ route('admin.cabang.store') }}";
            methodField.innerHTML = "";
            form.reset();
        }

        function openModalEdit(data) {
            modal.classList.remove('hidden');
            modalTitle.innerText = "✏️ Edit Data Cabang";
            form.action = `/admin/cabang/update/${data.id}`;
            methodField.innerHTML = `<input type="hidden" name="_method" value="PUT">`;

            document.getElementById('in_nama').value = data.nama_cabang;
            document.getElementById('in_lokasi').value = data.lokasi;
            document.getElementById('in_agen').value = data.total_agen;
        }

        function closeModal() {
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
