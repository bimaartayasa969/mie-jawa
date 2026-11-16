@extends('layouts.app')

@section('title', $menu->nama_menu . ' - Menu Kuliner Mie Jawa')
@section('description', 'Detail sajian ' . $menu->nama_menu . ' khas warung Mie Jawa masak anglo arang. ' . \Illuminate\Support\Str::limit($menu->deskripsi, 140))

@php
    $waNumber = $profil && $profil->no_whatsapp ? preg_replace('/[^0-9]/', '', $profil->no_whatsapp) : '6281549077231';
    if (str_starts_with($waNumber, '0')) {
        $waNumber = '62' . substr($waNumber, 1);
    }
    $pesanWa = "Halo Warung Mie Jawa, saya ingin memesan menu *{$menu->nama_menu}* (Rp " . number_format($menu->harga, 0, ',', '.') . "). Apakah saat ini tersedia?";
    $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode($pesanWa);
@endphp

@section('content')
<section class="py-8 sm:py-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb Navigasi -->
        <nav class="flex items-center gap-2 text-xs text-[#8C7A70] mb-8 overflow-x-auto whitespace-nowrap pb-1">
            <a href="{{ route('beranda') }}" class="hover:text-[#B3281A] transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('katalog') }}" class="hover:text-[#B3281A] transition">Katalog Menu</a>
            <span>/</span>
            <span class="text-[#2B1B10] font-semibold">{{ $menu->nama_menu }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- Kolom Kiri: Tampilan Foto Menu -->
            <div class="lg:col-span-6">
                <div class="bg-white rounded-3xl p-3 border border-[#F5E8D3] shadow-md relative overflow-hidden">
                    <div class="relative aspect-4/3 rounded-2xl overflow-hidden bg-[#FFF3E3]">
                        @if ($menu->foto && (file_exists(public_path('storage/' . $menu->foto)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->foto)))
                            <img src="{{ asset('storage/' . $menu->foto) }}" alt="Foto sajian {{ $menu->nama_menu }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-6xl bg-gradient-to-br from-[#FFF5E6] to-[#FFE8CC] text-[#8C7A70]">
                                🍜
                                <span class="text-xs font-semibold text-[#6B5B52] mt-3">Sajian Anglo Arang</span>
                            </div>
                        @endif

                        <!-- Badge Kategori -->
                        <span class="absolute top-4 left-4 bg-[#B3281A] text-white text-xs font-bold tracking-wider px-3 py-1.5 rounded-xl uppercase shadow-sm">
                            {{ $menu->kategori }}
                        </span>

                        <!-- Badge Favorit / Unggulan -->
                        @if ($menu->is_unggulan)
                            <span class="absolute bottom-4 left-4 bg-[#F2B84B] text-[#2B1B10] text-xs font-bold px-3 py-1 rounded-xl shadow-sm flex items-center gap-1.5">
                                <span>✨</span>
                                <span>Pilihan Favorit Pelanggan</span>
                            </span>
                        @endif

                        <!-- Badge Status -->
                        <span class="absolute top-4 right-4 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm {{ $menu->status === 'tersedia' ? 'bg-white text-emerald-800 border border-emerald-200' : 'bg-red-50 text-[#B3281A] border border-red-200' }}">
                            {{ $menu->status === 'tersedia' ? '● Tersedia' : '● Stok Habis' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Rincian Hidangan & Pemesanan -->
            <div class="lg:col-span-6 space-y-6">
                <div>
                    <div class="inline-block text-xs font-bold text-[#B3281A] uppercase tracking-wider mb-1">
                        Sajian Kategori: {{ $menu->kategori }}
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-serif font-bold text-[#2B1B10] leading-tight">
                        {{ $menu->nama_menu }}
                    </h1>
                </div>

                <!-- Harga Hidangan -->
                <div class="p-4 rounded-2xl bg-white border border-[#F5E8D3] shadow-xs flex items-center justify-between">
                    <div>
                        <span class="block text-[11px] font-semibold text-[#8C7A70] uppercase tracking-wider">Harga Sajian</span>
                        <span class="text-2xl sm:text-3xl font-extrabold text-[#B3281A]">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-bold {{ $menu->status === 'tersedia' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-red-50 text-[#B3281A] border border-red-200' }}">
                            {{ $menu->status === 'tersedia' ? 'Siap Saji Hari Ini' : 'Bahan Baku Habis' }}
                        </span>
                    </div>
                </div>

                <!-- Deskripsi Sajian Lengkap -->
                <div class="space-y-2">
                    <h3 class="font-serif font-bold text-sm text-[#2B1B10] uppercase tracking-wider">Deskripsi Hidangan</h3>
                    <p class="text-xs sm:text-sm text-[#6B5B52] leading-relaxed">
                        {{ $menu->deskripsi ?: 'Hidangan kuliner istimewa khas Mie Jawa yang diracik menggunakan bumbu ulekan segar tradisional, kaldu ayam kampung gurih, dan dimasak secara autentik di atas wajan anglo berbahan bakar arang.' }}
                    </p>
                </div>

                <!-- Tiga Jaminan Mutu -->
                <div class="grid grid-cols-2 gap-3 text-xs text-[#2B1B10]">
                    <div class="p-3 bg-white rounded-xl border border-[#F5E8D3] flex items-center gap-2">
                        <span>🔥</span>
                        <span>Aroma Smokey Anglo Arang</span>
                    </div>
                    <div class="p-3 bg-white rounded-xl border border-[#F5E8D3] flex items-center gap-2">
                        <span>🍲</span>
                        <span>Kaldu Gurih Ayam Kampung</span>
                    </div>
                </div>

                <!-- Tombol Aksi Pesan WhatsApp -->
                <div class="space-y-3 pt-2">
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" 
                        class="w-full bg-[#B3281A] hover:bg-[#8F1F14] text-white font-semibold py-3.5 px-6 rounded-2xl shadow-md min-h-[44px] flex items-center justify-center gap-2.5 transition text-xs sm:text-sm cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.155.57 4.179 1.569 5.924l-1.569 5.736 5.894-1.545c1.706.945 3.663 1.485 5.75 1.485 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z"/>
                        </svg>
                        <span>{{ $menu->status === 'tersedia' ? 'Pesan / Tanya via WhatsApp' : 'Tanyakan Ketersediaan Bahan via WA' }}</span>
                    </a>

                    <a href="{{ route('katalog') }}" class="w-full bg-white hover:bg-[#F5E8D3] border border-[#E5D7C3] text-[#2B1B10] font-semibold py-3 px-6 rounded-2xl min-h-[44px] flex items-center justify-center gap-2 transition text-xs sm:text-sm">
                        <span>← Kembali ke Katalog Menu</span>
                    </a>
                </div>

            </div>

        </div>

    </div>
</section>
@endsection

