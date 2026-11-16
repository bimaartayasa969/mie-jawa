@props(['menu', 'mode' => 'publik'])

<div class="bg-white rounded-3xl border border-[#F5E8D3] shadow-sm hover:shadow-md transition overflow-hidden flex flex-col group">
    
    <!-- Area Gambar Hidangan & Badge -->
    <div class="relative w-full aspect-4/3 bg-[#FFF3E3] overflow-hidden">
        @if ($menu->foto && (file_exists(public_path('storage/' . $menu->foto)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->foto)))
            <img src="{{ asset('storage/' . $menu->foto) }}" 
                 alt="Foto sajian {{ $menu->nama_menu }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        @else
            <!-- Ilustrasi Placeholder Bersih Sesuai Palet -->
            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-[#FFF5E6] to-[#FFE8CC] text-[#8C7A70] p-4 text-center">
                <div class="w-16 h-16 rounded-2xl bg-white/80 backdrop-blur-xs flex items-center justify-center text-3xl shadow-xs mb-2">
                    🍜
                </div>
                <span class="text-[11px] font-semibold text-[#6B5B52]">{{ $menu->kategori }} Masak Anglo</span>
            </div>
        @endif

        <!-- Badge Kategori (Kiri Atas) -->
        <span class="absolute top-3 left-3 bg-[#B3281A] text-white text-[10px] font-bold tracking-wider px-2.5 py-1 rounded-lg uppercase shadow-xs">
            {{ $menu->kategori }}
        </span>

        <!-- Badge Unggulan / Favorit (Kiri Bawah Gambar) -->
        @if ($menu->is_unggulan)
            <span class="absolute bottom-3 left-3 bg-[#F2B84B] text-[#2B1B10] text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-xs flex items-center gap-1">
                <span>✨</span>
                <span>Favorit</span>
            </span>
        @endif

        <!-- Badge Status Ketersediaan (Kanan Atas) -->
        <span class="absolute top-3 right-3 text-[11px] font-bold px-2.5 py-1 rounded-full shadow-xs {{ $menu->status === 'tersedia' ? 'bg-white/95 text-emerald-800 border border-emerald-200' : 'bg-red-50 text-[#B3281A] border border-red-200' }}">
            {{ $menu->status === 'tersedia' ? 'Tersedia' : 'Habis' }}
        </span>
    </div>

    <!-- Area Rincian Menu -->
    <div class="p-5 flex-1 flex flex-col">
        <div class="flex items-center justify-between text-[11px] text-[#8C7A70] font-semibold uppercase tracking-wider mb-1">
            <span>{{ $menu->kategori }}</span>
            <span class="{{ $menu->status === 'tersedia' ? 'text-emerald-700' : 'text-[#B3281A]' }}">
                ● {{ ucfirst($menu->status) }}
            </span>
        </div>

        <h3 class="font-serif font-bold text-lg text-[#2B1B10] group-hover:text-[#B3281A] transition leading-snug">
            {{ $menu->nama_menu }}
        </h3>

        <p class="text-xs text-[#6B5B52] mt-1.5 line-clamp-2 leading-relaxed flex-1">
            {{ $menu->deskripsi ?: 'Hidangan autentik dimasak segar satu per satu menggunakan racikan bumbu rempah pilihan.' }}
        </p>

        <!-- Baris Bawah: Harga & Aksi -->
        <div class="pt-4 mt-4 border-t border-[#F7EFE2] flex items-center justify-between gap-3">
            <div>
                <span class="block text-[10px] text-[#8C7A70] font-medium uppercase tracking-wider">Harga</span>
                <span class="text-base sm:text-lg font-bold text-[#B3281A]">
                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                </span>
            </div>

            @if ($mode === 'admin')
                <div class="flex items-center gap-1.5">
                    <a href="{{ route('katalog.detail', $menu) }}" target="_blank" class="p-2 bg-gray-100 hover:bg-gray-200 text-[#2B1B10] rounded-xl text-xs font-semibold min-h-[44px] min-w-[44px] flex items-center justify-center transition" title="Lihat Detail Tampilan">
                        👁️
                    </a>
                    <a href="{{ route('admin.menu.edit', $menu) }}" class="p-2 bg-[#FFF8EE] hover:bg-[#F2B84B] border border-[#E5D7C3] text-[#2B1B10] rounded-xl text-xs font-semibold min-h-[44px] min-w-[44px] flex items-center justify-center transition" title="Ubah Menu">
                        ✏️
                    </a>
                </div>
            @else
                <a href="{{ route('katalog.detail', $menu) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#FFF8EE] hover:bg-[#B3281A] text-[#2B1B10] hover:text-white border border-[#E5D7C3] hover:border-[#B3281A] rounded-xl text-xs font-semibold min-h-[44px] transition cursor-pointer">
                    <span>Detail</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            @endif
        </div>
    </div>

</div>

