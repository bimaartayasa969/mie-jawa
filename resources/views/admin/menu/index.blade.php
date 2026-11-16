@extends('layouts.admin')

@section('title', 'Daftar & Kelola Menu')
@section('header_title', 'Katalog Usaha - Kelola Menu')

@section('content')
<div class="space-y-6">

    <!-- Header Kelola Menu & Tombol Aksi Sesuai Mockup 165629 & 165659 -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <span class="block text-xs font-bold text-[#B3281A] uppercase tracking-wider mb-1">
                Katalog Usaha
            </span>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#2B1B10]">
                Daftar &amp; Kelola Menu
            </h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-1">
                Lihat daftar seluruh sajian kuliner, perbarui ketersediaan, ubah data hidangan, atau tambah menu baru.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 shrink-0">
            <!-- Pilihan Alih Tampilan (Visual vs Tabel) -->
            <div class="bg-[#FFF8EE] border border-[#E5D7C3] p-1 rounded-2xl flex items-center">
                <a href="{{ route('admin.menu.index', array_filter(['tampilan' => 'visual', 'kategori' => $kategori, 'cari' => $cari])) }}" 
                    class="px-3 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition min-h-[36px] {{ $tampilan === 'visual' ? 'bg-[#B3281A] text-white shadow-xs' : 'text-[#6B5B52] hover:text-[#2B1B10]' }}">
                    <span>🖼️</span>
                    <span>Daftar Visual</span>
                </a>
                <a href="{{ route('admin.menu.index', array_filter(['tampilan' => 'tabel', 'kategori' => $kategori, 'cari' => $cari])) }}" 
                    class="px-3 py-1.5 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition min-h-[36px] {{ $tampilan === 'tabel' ? 'bg-[#B3281A] text-white shadow-xs' : 'text-[#6B5B52] hover:text-[#2B1B10]' }}">
                    <span>📋</span>
                    <span>Tabel Kelola</span>
                </a>
            </div>

            <!-- Tombol Tambah Menu -->
            <a href="{{ route('admin.menu.create') }}" class="px-5 py-2.5 bg-[#B3281A] hover:bg-[#8F1F14] text-white rounded-xl text-xs sm:text-sm font-semibold min-h-[44px] flex items-center gap-2 shadow-sm transition cursor-pointer">
                <span>+</span>
                <span>Tambah Menu</span>
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian Menu -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#F5E8D3] shadow-sm space-y-4">
        <form action="{{ route('admin.menu.index') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            <input type="hidden" name="tampilan" value="{{ $tampilan }}">
            @if ($kategori)
                <input type="hidden" name="kategori" value="{{ $kategori }}">
            @endif

            <!-- Input Pencarian -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari menu berdasarkan nama atau bahan..."
                    class="w-full pl-10 pr-20 py-2.5 bg-[#FFF8EE]/50 border border-[#E5D7C3] rounded-2xl text-xs sm:text-sm text-[#2B1B10] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#B3281A] min-h-[44px]">
                
                <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-3.5 bg-[#B3281A] hover:bg-[#8F1F14] text-white text-xs font-semibold rounded-xl flex items-center transition cursor-pointer">
                    Cari
                </button>
            </div>

            <!-- Kancing Kategori Filter -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-none">
                <a href="{{ route('admin.menu.index', array_filter(['tampilan' => $tampilan, 'cari' => $cari])) }}" 
                    class="px-3.5 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition min-h-[40px] flex items-center {{ empty($kategori) ? 'bg-[#B3281A] text-white' : 'bg-[#FFF8EE] text-[#2B1B10] border border-[#E5D7C3]' }}">
                    Semua Kategori
                </a>

                @foreach ($kategoriList as $kat)
                    <a href="{{ route('admin.menu.index', array_filter(['tampilan' => $tampilan, 'kategori' => $kat, 'cari' => $cari])) }}" 
                        class="px-3.5 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition min-h-[40px] flex items-center {{ $kategori === $kat ? 'bg-[#B3281A] text-white' : 'bg-[#FFF8EE] text-[#2B1B10] border border-[#E5D7C3]' }}">
                        {{ $kat }}
                    </a>
                @endforeach
            </div>
        </form>

        <div class="text-xs text-[#8C7A70] flex items-center justify-between border-t border-[#F7EFE2] pt-3">
            <span>Menampilkan <strong class="text-[#2B1B10]">{{ $daftarMenu->count() }}</strong> menu sajian</span>
            @if ($kategori || $cari)
                <a href="{{ route('admin.menu.index', ['tampilan' => $tampilan]) }}" class="text-[#B3281A] hover:underline font-semibold">
                    ✕ Reset Pencarian
                </a>
            @endif
        </div>
    </div>

    <!-- Tampilan 1: Tabel Kelola (Sesuai Mockup 165659) -->
    @if ($tampilan === 'tabel')
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#F5E8D3]">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b border-[#F5E8D3] text-[#8C7A70] font-bold uppercase text-[11px] tracking-wider">
                            <th class="py-3 px-3">Foto Mini</th>
                            <th class="py-3 px-3">Nama Menu</th>
                            <th class="py-3 px-3">Kategori</th>
                            <th class="py-3 px-3">Harga</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3">Unggulan</th>
                            <th class="py-3 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F7EFE2]">
                        @forelse ($daftarMenu as $item)
                            <tr class="hover:bg-[#FFFDF9] transition">
                                <!-- Foto Mini -->
                                <td class="py-3 px-3">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden bg-[#FFF3E3] border border-[#F5E8D3] shrink-0">
                                        @if ($item->foto && file_exists(public_path('storage/' . $item->foto)))
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_menu }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xl bg-gradient-to-br from-[#FFF5E6] to-[#FFE8CC]">
                                                🍜
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Nama Menu & Deskripsi -->
                                <td class="py-3 px-3 max-w-xs">
                                    <div class="font-bold text-[#2B1B10] text-sm">{{ $item->nama_menu }}</div>
                                    <div class="text-xs text-[#8C7A70] line-clamp-1 mt-0.5">{{ $item->deskripsi }}</div>
                                </td>

                                <!-- Kategori -->
                                <td class="py-3 px-3">
                                    <span class="inline-block px-2.5 py-1 rounded-lg bg-[#FFF8EE] border border-[#E5D7C3] text-[11px] font-semibold text-[#2B1B10]">
                                        {{ $item->kategori }}
                                    </span>
                                </td>

                                <!-- Harga -->
                                <td class="py-3 px-3 font-bold text-[#B3281A] whitespace-nowrap">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </td>

                                <!-- Status -->
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold {{ $item->status === 'tersedia' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-red-50 text-[#B3281A] border border-red-200' }}">
                                        <span>{{ $item->status === 'tersedia' ? '✓' : '✕' }}</span>
                                        <span>{{ ucfirst($item->status) }}</span>
                                    </span>
                                </td>

                                <!-- Unggulan -->
                                <td class="py-3 px-3">
                                    @if ($item->is_unggulan)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-900 border border-amber-200 text-[11px] font-bold">
                                            <span>✨</span>
                                            <span>Unggulan</span>
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                <!-- Aksi (Detail, Edit, Hapus) -->
                                <td class="py-3 px-3 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5 justify-end">
                                        <!-- Lihat Detail Publik -->
                                        <a href="{{ route('katalog.detail', $item) }}" target="_blank" 
                                            class="w-9 h-9 rounded-xl bg-gray-50 border border-gray-200 hover:bg-gray-100 text-[#2B1B10] flex items-center justify-center transition min-h-[36px] min-w-[36px]" 
                                            title="Buka Halaman Detail Publik">
                                            👁️
                                        </a>

                                        <!-- Edit Menu -->
                                        <a href="{{ route('admin.menu.edit', $item) }}" 
                                            class="w-9 h-9 rounded-xl bg-[#FFF8EE] border border-[#E5D7C3] hover:border-[#F2B84B] text-[#2B1B10] flex items-center justify-center transition min-h-[36px] min-w-[36px]" 
                                            title="Ubah Data Menu">
                                            ✏️
                                        </a>

                                        <!-- Hapus Menu (Membuka Dialog Konfirmasi) -->
                                        <button type="button" 
                                            onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->nama_menu) }}', '{{ route('admin.menu.destroy', $item) }}')"
                                            class="w-9 h-9 rounded-xl bg-red-50 border border-red-200 hover:bg-red-100 text-[#B3281A] flex items-center justify-center transition min-h-[36px] min-w-[36px] cursor-pointer" 
                                            title="Hapus Menu">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-[#6B5B52]">
                                    Belum ada sajian menu yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Tampilan 2: Kartu Visual (Sesuai Mockup 165629) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($daftarMenu as $item)
                <div class="relative">
                    <x-kartu-menu :menu="$item" mode="admin" />
                    <!-- Tombol Hapus Cepat di Kartu Visual -->
                    <div class="absolute top-3 right-24 z-10">
                        <button type="button" 
                            onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->nama_menu) }}', '{{ route('admin.menu.destroy', $item) }}')"
                            class="p-2 bg-white/90 backdrop-blur-xs hover:bg-red-50 text-[#B3281A] rounded-xl border border-red-200 shadow-xs min-h-[36px] min-w-[36px] flex items-center justify-center cursor-pointer transition"
                            title="Hapus Menu">
                            🗑️
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-10 text-center border border-[#F5E8D3]">
                    <p class="text-sm text-[#6B5B52]">Belum ada data menu. Silakan klik tombol Tambah Menu.</p>
                </div>
            @endforelse
        </div>
    @endif

</div>

<!-- Modal Dialog Konfirmasi Hapus Menu (Wajib Dialog Konfirmasi) -->
<div id="delete-modal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-[#F5E8D3] space-y-5 animate-in fade-in zoom-in-95 duration-200">
        
        <div class="w-14 h-14 rounded-2xl bg-red-100 text-[#B3281A] flex items-center justify-center text-2xl mx-auto">
            ⚠️
        </div>

        <div class="text-center space-y-2">
            <h3 class="text-lg sm:text-xl font-serif font-bold text-[#2B1B10]">
                Konfirmasi Hapus Menu
            </h3>
            <p class="text-xs sm:text-sm text-[#6B5B52] leading-relaxed">
                Apakah Anda yakin ingin menghapus sajian <strong id="modal-menu-name" class="text-[#2B1B10]"></strong>? Berkas foto terkait juga akan dihapus permanen dari media penyimpanan server.
            </p>
        </div>

        <form id="delete-form" method="POST" action="" class="flex items-center gap-3 pt-2">
            @csrf
            @method('DELETE')

            <button type="button" onclick="closeDeleteModal()" 
                class="flex-1 py-3 px-4 bg-gray-100 hover:bg-gray-200 text-[#2B1B10] font-semibold rounded-xl text-xs sm:text-sm min-h-[44px] transition cursor-pointer">
                Batal
            </button>

            <button type="submit" 
                class="flex-1 py-3 px-4 bg-[#B3281A] hover:bg-[#8F1F14] text-white font-semibold rounded-xl text-xs sm:text-sm min-h-[44px] transition shadow-md cursor-pointer">
                Ya, Hapus Menu
            </button>
        </form>

    </div>
</div>

<script>
    function openDeleteModal(id, namaMenu, urlAksi) {
        document.getElementById('modal-menu-name').textContent = `"${namaMenu}"`;
        document.getElementById('delete-form').action = urlAksi;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
</script>
@endsection
