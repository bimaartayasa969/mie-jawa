<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasbor Pengelolaan') - Panel Mie Jawa</title>
    <meta name="description" content="@yield('meta_description', 'Panel pengelolaan operasional menu hidangan, kampanye promosi, dan profil usaha UMKM Mie Jawa.')">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFF8EE] text-[#2B1B10] font-sans antialiased min-h-screen">

    <div class="min-h-screen flex">
        
        <!-- Backdrop Mobile -->
        <div id="admin-sidebar-backdrop" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden transition-opacity"></div>

        <!-- Sidebar Dasbor -->
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-[#1C120C] text-[#FFF8EE] flex flex-col justify-between p-5 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl md:shadow-none">
            
            <div class="space-y-6">
                <!-- Header Sidebar: Logo & Tombol Tutup Mobile -->
                <div class="flex items-center justify-between pb-4 border-b border-[#332217]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#B3281A] text-[#F2B84B] flex items-center justify-center shadow-md shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <span class="block text-lg font-serif font-bold text-white tracking-tight">Mie Jawa</span>
                            <span class="block text-[10px] font-bold tracking-wider text-[#A6998F] uppercase">Panel Pengelolaan</span>
                        </div>
                    </div>

                    <button type="button" id="admin-sidebar-close" class="md:hidden text-gray-400 hover:text-white p-2 min-h-[44px] min-w-[44px] flex items-center justify-center" aria-label="Tutup Menu">
                        ✕
                    </button>
                </div>

                <!-- Kartu Identitas Aktor Sesuai Peran -->
                @php
                    $user = auth()->user();
                    $isOwner = $user && $user->isOwner();
                @endphp
                <div class="p-3.5 rounded-2xl border {{ $isOwner ? 'bg-[#351610] border-[#5E2218]' : 'bg-[#182B1E] border-[#294A34]' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-base shrink-0 {{ $isOwner ? 'bg-[#B3281A] text-white' : 'bg-emerald-700 text-white' }}">
                            {{ $isOwner ? '👑' : '🛡️' }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="block text-[10px] font-bold tracking-wider uppercase {{ $isOwner ? 'text-[#FCA5A5]' : 'text-emerald-300' }}">
                                PERAN: {{ $isOwner ? 'OWNER' : 'ADMIN' }}
                            </span>
                            <div class="text-xs font-bold text-white truncate">
                                {{ $user ? $user->nama : 'Pengguna' }}
                            </div>
                            <div class="text-[10px] text-[#A6998F] truncate">
                                {{ $user ? $user->email : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-2.5 pt-2 border-t {{ $isOwner ? 'border-[#5E2218]' : 'border-[#294A34]' }} flex items-center justify-between text-[10px]">
                        <span class="text-[#A6998F]">Status:</span>
                        <span class="text-emerald-400 font-semibold flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Login Aktif
                        </span>
                    </div>
                </div>

                <!-- Daftar Navigasi Utama Sidebar -->
                <nav class="space-y-1.5">
                    
                    {{-- Dashboard (Owner & Admin) --}}
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition min-h-[44px] {{ request()->routeIs('admin.dashboard') ? 'bg-[#B3281A] text-white shadow-sm' : 'text-[#D1C7BD] hover:bg-[#2C1D14] hover:text-white' }}">
                        <span class="text-base">📊</span>
                        <span>Dashboard</span>
                    </a>

                    {{-- Kelola Menu (Owner & Admin) --}}
                    <a href="{{ route('admin.menu.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition min-h-[44px] {{ request()->routeIs('admin.menu*') ? 'bg-[#B3281A] text-white shadow-sm' : 'text-[#D1C7BD] hover:bg-[#2C1D14] hover:text-white' }}">
                        <span class="text-base">🍜</span>
                        <span>Daftar &amp; Kelola Menu</span>
                    </a>

                    {{-- Banner Promosi (Owner & Admin) --}}
                    <a href="{{ route('admin.promosi.index') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition min-h-[44px] {{ request()->routeIs('admin.promosi*') ? 'bg-[#B3281A] text-white shadow-sm' : 'text-[#D1C7BD] hover:bg-[#2C1D14] hover:text-white' }}">
                        <span class="text-base">🏷️</span>
                        <span>Banner Promosi</span>
                    </a>

                    {{-- Profil Usaha (Owner & Admin) --}}
                    <a href="{{ route('admin.profil-usaha.edit') }}"
                        class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition min-h-[44px] {{ request()->routeIs('admin.profil-usaha*') ? 'bg-[#B3281A] text-white shadow-sm' : 'text-[#D1C7BD] hover:bg-[#2C1D14] hover:text-white' }}">
                        <span class="text-base">🏪</span>
                        <span>Profil Usaha</span>
                    </a>

                    {{-- Kelola Akun Admin (Khusus Owner) --}}
                    @if ($isOwner)
                        <a href="{{ route('admin.akun.index') }}"
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-semibold transition min-h-[44px] {{ request()->routeIs('admin.akun*') ? 'bg-[#B3281A] text-white shadow-sm' : 'text-[#D1C7BD] hover:bg-[#2C1D14] hover:text-white' }}">
                            <span class="text-base">👥</span>
                            <span>Kelola Akun Admin</span>
                        </a>
                    @endif

                </nav>

            </div>

            <!-- Footer Sidebar: Tautan Website & Logout -->
            <div class="pt-4 border-t border-[#332217] space-y-2">
                <!-- Tautan Lihat Website -->
                <a href="{{ route('beranda') }}" target="_blank" rel="noopener noreferrer"
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-[#D1C7BD] hover:text-white hover:bg-[#2C1D14] transition min-h-[44px]">
                    <span class="flex items-center gap-2">
                        <span>🌐</span>
                        <span>Lihat Website Publik</span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#A6998F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                <!-- Form Keluar (Logout) -->
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-[#FCA5A5] hover:bg-[#B3281A] hover:text-white transition cursor-pointer min-h-[44px]">
                        <span>🚪</span>
                        <span>Keluar ({{ $isOwner ? 'Pemilik Usaha' : 'Administrator' }})</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- Area Konten Utama -->
        <div class="flex-1 md:ml-72 flex flex-col min-h-screen">
            
            <!-- Topbar Mobile & Breadcrumb -->
            <header class="bg-white/80 backdrop-blur-md border-b border-[#F5E8D3] sticky top-0 z-30 px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button type="button" id="admin-sidebar-toggle" class="md:hidden p-2 text-[#2B1B10] hover:text-[#B3281A] rounded-xl border border-[#E5D7C3] bg-white min-h-[44px] min-w-[44px] flex items-center justify-center cursor-pointer" aria-label="Buka Menu Sidebar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="text-sm sm:text-base font-serif font-bold text-[#2B1B10]">
                        @yield('header_title', 'Dasbor Pengelolaan')
                    </h2>
                </div>

                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-block text-xs font-semibold px-3 py-1 rounded-full {{ $isOwner ? 'bg-[#FEF2F2] text-[#B3281A] border border-[#FCA5A5]' : 'bg-emerald-50 text-emerald-800 border border-emerald-200' }}">
                        {{ $isOwner ? 'Pemilik Usaha (Owner)' : 'Administrator (Admin)' }}
                    </span>
                    <a href="{{ route('beranda') }}" target="_blank" class="p-2 text-xs font-semibold text-[#6B5B52] hover:text-[#B3281A] rounded-xl min-h-[44px] flex items-center gap-1.5 transition" title="Lihat Website">
                        <span>Website</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Konten Halaman -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <x-alert />
                @yield('content')
            </main>

            <!-- Footer Panel Admin -->
            <footer class="py-4 px-6 border-t border-[#F5E8D3] text-center text-xs text-[#8C7A70]">
                Panel Pengelolaan UMKM Mie Jawa Masak Anglo Arang &copy; 2026.
            </footer>

        </div>

    </div>

    <!-- Script Drawer Sidebar Mobile -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('admin-sidebar-backdrop');
            const toggleBtn = document.getElementById('admin-sidebar-toggle');
            const closeBtn = document.getElementById('admin-sidebar-close');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>
</body>
</html>
