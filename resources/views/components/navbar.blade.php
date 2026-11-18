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
                <!-- Tombol Tanya via WhatsApp -->
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-[#B3281A] hover:bg-[#8F1F14] text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-2xl shadow-sm min-h-[44px] transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.155.57 4.179 1.569 5.924l-1.569 5.736 5.894-1.545c1.706.945 3.663 1.485 5.75 1.485 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z"/>
                    </svg>
                    <span>Tanya via WhatsApp</span>
                </a>

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
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="p-2.5 bg-[#B3281A] text-white rounded-xl min-h-[44px] min-w-[44px] flex items-center justify-center shadow-xs" aria-label="WhatsApp">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.155.57 4.179 1.569 5.924l-1.569 5.736 5.894-1.545c1.706.945 3.663 1.485 5.75 1.485 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
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

