@extends('layouts.app')

@section('title', 'Katalog Menu Sajian Lengkap - Mie Jawa')
@section('description', 'Jelajahi seluruh daftar sajian kuliner Mie Jawa, aneka mie rebus godog, mie goreng, soto ayam, nasi goreng anglo, dan minuman tradisional.')

@section('content')
<section class="py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Halaman Katalog Sesuai Mockup 165455 -->
        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="text-xs font-bold text-[#B3281A] uppercase tracking-wider">Daftar Sajian Penuh Kenikmatan</span>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-[#2B1B10] mt-1.5">
                Katalog Menu Mie Jawa
            </h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-2 leading-relaxed">
                Pilih hidangan favorit Anda. Semua hidangan dimasak segar satu per satu menggunakan rempah asli dan bahan berkualitas.
            </p>
        </div>

        <!-- Filter & Bar Pencarian -->
        <div class="bg-white rounded-3xl p-5 sm:p-6 border border-[#F5E8D3] shadow-sm mb-10 space-y-4">
            
            <form action="{{ route('katalog') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
                @if (request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif

                <!-- Kolom Input Pencarian -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="cari" value="{{ $cari }}" placeholder="Cari menu (cth: Godog, Wedang, Soto)..."
                        class="w-full pl-10 pr-24 py-2.5 bg-[#FFF8EE]/50 border border-[#E5D7C3] rounded-2xl text-xs sm:text-sm text-[#2B1B10] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#B3281A] focus:bg-white min-h-[44px]">
                    
                    <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-4 bg-[#B3281A] hover:bg-[#8F1F14] text-white text-xs font-semibold rounded-xl min-h-[36px] flex items-center transition cursor-pointer">
                        Cari
                    </button>
                </div>

                <!-- Informasi Jumlah Hasil Tampil -->
                <div class="text-xs text-[#8C7A70] text-center md:text-right shrink-0">
                    Menampilkan <strong class="text-[#2B1B10]">{{ $daftarMenu->count() }}</strong> dari <strong class="text-[#2B1B10]">{{ $totalMenu }}</strong> menu
                </div>
            </form>

            <!-- Kancing Pill Kategori -->
            <div class="pt-3 border-t border-[#F7EFE2] flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                <span class="text-xs font-bold text-[#2B1B10] shrink-0 mr-1 flex items-center gap-1">
                    <span>🗂️</span>
                    <span>Kategori:</span>
                </span>

                <!-- Tombol Semua Menu -->
                <a href="{{ route('katalog', array_filter(['cari' => $cari])) }}" 
                    class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition min-h-[44px] flex items-center {{ empty($kategori) ? 'bg-[#B3281A] text-white shadow-xs' : 'bg-[#FFF8EE] text-[#2B1B10] border border-[#E5D7C3] hover:border-[#B3281A]' }}">
                    Semua Menu
                </a>

                @foreach ($kategoriList as $kat)
                    <a href="{{ route('katalog', array_filter(['kategori' => $kat, 'cari' => $cari])) }}" 
                        class="px-4 py-2 rounded-xl text-xs font-semibold whitespace-nowrap transition min-h-[44px] flex items-center {{ $kategori === $kat ? 'bg-[#B3281A] text-white shadow-xs' : 'bg-[#FFF8EE] text-[#2B1B10] border border-[#E5D7C3] hover:border-[#B3281A]' }}">
                        {{ $kat }}
                    </a>
                @endforeach

                @if ($kategori || $cari)
                    <a href="{{ route('katalog') }}" class="text-xs text-[#B3281A] hover:underline font-semibold ml-auto whitespace-nowrap px-2 py-1 min-h-[44px] flex items-center">
                        ✕ Reset Filter
                    </a>
                @endif
            </div>

        </div>

        <!-- Grid Katalog Hidangan -->
        @if ($daftarMenu->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($daftarMenu as $item)
                    <x-kartu-menu :menu="$item" mode="publik" />
                @endforeach
            </div>
        @else
            <!-- Keadaan Kosong (Empty State) -->
            <div class="bg-white rounded-3xl p-12 text-center border border-[#F5E8D3] max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-3xl mx-auto mb-4">
                    🔍
                </div>
                <h3 class="text-lg font-serif font-bold text-[#2B1B10]">Menu Tidak Ditemukan</h3>
                <p class="text-xs text-[#6B5B52] mt-1.5 leading-relaxed">
                    Tidak ada hidangan yang cocok dengan kata kunci pencarian <span class="font-bold text-[#B3281A]">"{{ $cari }}"</span> atau filter kategori yang dipilih.
                </p>
                <div class="mt-6">
                    <a href="{{ route('katalog') }}" class="px-5 py-2.5 bg-[#B3281A] hover:bg-[#8F1F14] text-white text-xs font-semibold rounded-xl min-h-[44px] inline-flex items-center transition">
                        Tampilkan Semua Menu
                    </a>
                </div>
            </div>
        @endif

    </div>
</section>
@endsection
