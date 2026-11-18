@php
    $profil = \App\Models\ProfilUsaha::first();
    $namaUsaha = $profil ? $profil->nama_usaha : 'Mie Jawa Masak Anglo Arang';
    $alamat = $profil ? $profil->alamat : 'Jl. Sultan Abdurrahman, Mie Goreng Jawa, Pontianak, Kalimantan Barat';
    $noWa = $profil && $profil->no_whatsapp ? $profil->no_whatsapp : '0838 4586 3186';
    $ig = $profil && $profil->instagram ? $profil->instagram : '@miejawa.official';
    $jam = $profil && $profil->jam_operasional ? $profil->jam_operasional : 'Senin - Sabtu: 18.00 - 22.00 WIB | Minggu: Tutup / Libur';
@endphp

<footer class="bg-[#1F130B] text-[#FFF8EE] pt-14 pb-8 border-t border-[#332217]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- 4 Kolom Utama Footer -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-[#332217]">
            
            <!-- Kolom 1: Profil & Tagline Warung -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-[#B3281A] text-[#F2B84B] flex items-center justify-center shadow-md shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-lg font-serif font-bold text-white tracking-tight">Mie Jawa</span>
                        <span class="block text-[9px] font-bold tracking-widest text-[#F2B84B] uppercase">MASAK ANGLO ARANG</span>
                    </div>
                </div>
                <p class="text-xs text-[#D1C7BD] leading-relaxed">
                    Warung kuliner Mie Jawa bercita rasa autentik. Diracik dengan bumbu rempah ulekan segar, kaldu ayam kampung gurih, dan dimasak langsung menggunakan wajan anglo arang.
                </p>
                <div class="inline-block text-[11px] font-bold text-[#F2B84B] tracking-wide">
                    Katalog Promosi &amp; Informasi UMKM Kuliner
                </div>
            </div>

            <!-- Kolom 2: Tautan Halaman Publik -->
            <div>
                <h4 class="font-serif font-bold text-sm text-[#F2B84B] mb-4 uppercase tracking-wider">Halaman Publik</h4>
                <ul class="space-y-2.5 text-xs text-[#D1C7BD]">
                    <li>
                        <a href="{{ route('beranda') }}" class="hover:text-white transition inline-flex items-center min-h-[36px]">Beranda</a>
                    </li>
                    <li>
                        <a href="{{ route('katalog') }}" class="hover:text-white transition inline-flex items-center min-h-[36px]">Katalog Menu Lengkap</a>
                    </li>
                    <li>
                        <a href="{{ route('lokasi') }}" class="hover:text-white transition inline-flex items-center min-h-[36px]">Lokasi &amp; Petunjuk Arah</a>
                    </li>
                    <li>
                        <a href="{{ route('kontak') }}" class="hover:text-white transition inline-flex items-center min-h-[36px]">Kontak &amp; WhatsApp</a>
                    </li>
                </ul>
            </div>

            <!-- Kolom 3: Jam Operasional -->
            <div>
                <h4 class="font-serif font-bold text-sm text-[#F2B84B] mb-4 uppercase tracking-wider">Jam Operasional</h4>
                <div class="space-y-3 text-xs text-[#D1C7BD]">
                    <div>
                        <div class="font-bold text-white">Senin – Sabtu</div>
                        <div class="text-[#F2B84B] mt-0.5">18.00 – 22.00 WIB</div>
                    </div>
                    <div class="pt-2 border-t border-[#332217]">
                        <div class="font-bold text-white">Minggu</div>
                        <div class="text-red-400 mt-0.5">Tutup / Libur</div>
                    </div>
                    <p class="text-[11px] text-[#A6998F] italic pt-1">
                        Melayani makan di tempat &amp; bungkus bawa pulang.
                    </p>
                </div>
            </div>

            <!-- Kolom 4: Hubungi Kami & Akses Aktor -->
            <div>
                <h4 class="font-serif font-bold text-sm text-[#F2B84B] mb-4 uppercase tracking-wider">Hubungi Kami</h4>
                <ul class="space-y-2.5 text-xs text-[#D1C7BD] mb-5">
                    <li class="flex items-center gap-2">
                        <span class="text-[#F2B84B]">📞</span>
                        <span>Telp: {{ $noWa }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#F2B84B]">💬</span>
                        <span>WA: {{ $noWa }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="text-[#F2B84B]">📷</span>
                        <span>{{ $ig }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-[#F2B84B] mt-0.5">📍</span>
                        <span class="line-clamp-2">{{ $alamat }}</span>
                    </li>
                </ul>

                <!-- Tombol Masuk Pengelola (Owner / Admin) -->
                <a href="{{ auth()->check() ? (auth()->user()->isOwner() ? route('admin.dashboard') : route('admin.menu.index')) : route('admin.login') }}"
                    class="w-full bg-[#2B1B10] border border-[#4A3B30] hover:border-[#F2B84B] text-white text-xs font-semibold px-4 py-2.5 rounded-xl min-h-[44px] flex items-center justify-center gap-2 transition group shadow-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#F2B84B] group-hover:scale-110 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Akses Aktor (Pemilik &amp; Admin)</span>
                </a>
            </div>

        </div>

        <!-- Bagian Bawah: Hak Cipta -->
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#A6998F]">
            <p>© 2026 Mie Jawa UMKM. Seluruh hak cipta dilindungi.</p>
            <p class="flex items-center gap-1">
                <span>Dibuat untuk memajukan UMKM Kuliner Tradisional</span>
                <span class="text-red-500">❤️</span>
            </p>
        </div>

    </div>
</footer>

