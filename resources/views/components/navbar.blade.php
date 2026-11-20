@php
    $profil = \App\Models\ProfilUsaha::first();
    $waNumber = $profil && $profil->no_whatsapp ? preg_replace('/[^0-9]/', '', $profil->no_whatsapp) : '6283845863186';
    if (str_starts_with($waNumber, '0')) {
        $waNumber = '62' . substr($waNumber, 1);
    }
    $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode("Halo Warung Mie Jawa, saya ingin bertanya tentang menu dan pemesanan.");
@endphp

<header class="sticky top-0 z-40 bg-[#FFF8EE]/95 backdrop-blur-md border-b border-[#F5E8D3]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Logo Brand -->
            <a href="{{ route('beranda') }}" class="flex items-center gap-3 group min-h-[44px]">
                <div class="w-11 h-11 rounded-2xl bg-[#B3281A] text-[#F2B84B] flex items-center justify-center shadow-md group-hover:scale-105 transition shrink-0">
                    <!-- Icon Anglo / Mangkok Mie -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <span class="block text-xl font-serif font-bold text-[#2B1B10] leading-tight tracking-tight group-hover:text-[#B3281A] transition">
                        Mie Jawa
                    </span>
                    <span class="block text-[10px] font-bold tracking-widest text-[#B3281A] uppercase">
                        MASAK ANGLO ARANG
                    </span>
                </div>
            </a>

            <!-- Navigasi Desktop -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('beranda') }}" class="py-2 text-sm transition font-medium min-h-[44px] flex items-center {{ request()->routeIs('beranda') ? 'text-[#B3281A] font-bold border-b-2 border-[#B3281A]' : 'text-[#2B1B10] hover:text-[#B3281A]' }}">
                    Beranda
                </a>
                <a href="{{ route('katalog') }}" class="py-2 text-sm transition font-medium min-h-[44px] flex items-center {{ request()->routeIs('katalog*') ? 'text-[#B3281A] font-bold border-b-2 border-[#B3281A]' : 'text-[#2B1B10] hover:text-[#B3281A]' }}">
                    Menu
                </a>
                <a href="{{ route('lokasi') }}" class="py-2 text-sm transition font-medium min-h-[44px] flex items-center {{ request()->routeIs('lokasi') ? 'text-[#B3281A] font-bold border-b-2 border-[#B3281A]' : 'text-[#2B1B10] hover:text-[#B3281A]' }}">
                    Lokasi
                </a>
                <a href="{{ route('kontak') }}" class="py-2 text-sm transition font-medium min-h-[44px] flex items-center {{ request()->routeIs('kontak') ? 'text-[#B3281A] font-bold border-b-2 border-[#B3281A]' : 'text-[#2B1B10] hover:text-[#B3281A]' }}">
                    Kontak
                </a>
            </nav>

            <!-- Aksi Kanan (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                <!-- Tombol Portal Pengelola / Aktor -->
                <a href="{{ auth()->check() ? (auth()->user()->isOwner() ? route('admin.dashboard') : route('admin.menu.index')) : route('admin.login') }}"
                    class="w-11 h-11 rounded-2xl border border-[#E5D7C3] bg-white hover:border-[#B3281A] flex items-center justify-center text-[#2B1B10] hover:text-[#B3281A] transition shadow-xs"
                    title="{{ auth()->check() ? 'Buka Dasbor (' . auth()->user()->nama . ')' : 'Portal Masuk Pengelola (Owner / Admin)' }}"
                    aria-label="Portal Masuk Pengelola">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </a>
            </div>

            <!-- Tombol Hamburger Mobile -->
            <div class="flex items-center gap-2 md:hidden">
                <button type="button" id="mobile-menu-toggle" class="p-2.5 text-[#2B1B10] hover:text-[#B3281A] rounded-xl border border-[#E5D7C3] bg-white min-h-[44px] min-w-[44px] flex items-center justify-center cursor-pointer" aria-label="Buka Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

        </div>

        <!-- Panel Menu Mobile -->
        <div id="mobile-menu-panel" class="hidden md:hidden pb-6 pt-2 border-t border-[#F5E8D3] space-y-2">
            <a href="{{ route('beranda') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold min-h-[44px] {{ request()->routeIs('beranda') ? 'bg-[#FEF2F2] text-[#B3281A]' : 'text-[#2B1B10] hover:bg-[#F5E8D3]/50' }}">
                Beranda
            </a>
            <a href="{{ route('katalog') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold min-h-[44px] {{ request()->routeIs('katalog*') ? 'bg-[#FEF2F2] text-[#B3281A]' : 'text-[#2B1B10] hover:bg-[#F5E8D3]/50' }}">
                Katalog Menu
            </a>
            <a href="{{ route('lokasi') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold min-h-[44px] {{ request()->routeIs('lokasi') ? 'bg-[#FEF2F2] text-[#B3281A]' : 'text-[#2B1B10] hover:bg-[#F5E8D3]/50' }}">
                Lokasi &amp; Jam Buka
            </a>
            <a href="{{ route('kontak') }}" class="block px-4 py-3 rounded-xl text-sm font-semibold min-h-[44px] {{ request()->routeIs('kontak') ? 'bg-[#FEF2F2] text-[#B3281A]' : 'text-[#2B1B10] hover:bg-[#F5E8D3]/50' }}">
                Kontak &amp; WhatsApp
            </a>
            <div class="pt-2 border-t border-[#F5E8D3] flex flex-col gap-2">
                <a href="{{ auth()->check() ? (auth()->user()->isOwner() ? route('admin.dashboard') : route('admin.menu.index')) : route('admin.login') }}" class="px-4 py-3 bg-white border border-[#E5D7C3] text-[#2B1B10] rounded-xl text-xs font-semibold text-center min-h-[44px] flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#B3281A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>{{ auth()->check() ? 'Buka Dasbor (' . auth()->user()->nama . ')' : 'Masuk Portal Pengelola' }}</span>
                </a>
            </div>
        </div>

    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const menuPanel = document.getElementById('mobile-menu-panel');
        if (toggleBtn && menuPanel) {
            toggleBtn.addEventListener('click', function () {
                menuPanel.classList.toggle('hidden');
            });
        }
    });
</script>

