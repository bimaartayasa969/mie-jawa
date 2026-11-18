@extends('layouts.app')

@section('title', 'Mie Jawa Masak Anglo Arang - Kenikmatan Tradisional Autentik')
@section('description', 'Warung kuliner Mie Jawa khas wajan anglo arang di Pontianak. Kaldu ayam kampung gurih, bumbu rempah ulekan segar, dan aroma wajan arang sedap.')

@php
    $waNumber = $profil && $profil->no_whatsapp ? preg_replace('/[^0-9]/', '', $profil->no_whatsapp) : '6281549077231';
    if (str_starts_with($waNumber, '0')) {
        $waNumber = '62' . substr($waNumber, 1);
    }
    $waUrl = "https://wa.me/{$waNumber}?text=" . urlencode("Halo Warung Mie Jawa, saya ingin bertanya tentang menu dan pemesanan hari ini.");
    $lat = $profil->latitude ?? -0.03550000;
    $lng = $profil->longitude ?? 109.33100000;
    $gmapsUrl = "https://www.google.com/maps?q={$lat},{$lng}";
@endphp

@section('content')
<!-- 1. Hero Section Sesuai Mockup 165301 -->
<section class="relative py-12 sm:py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Kolom Kiri: Teks & Aksi Utama -->
            <div class="lg:col-span-7 space-y-6 text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#FEF2F2] border border-[#FCA5A5] text-[#B3281A] text-xs font-semibold">
                    <span>🔥</span>
                    <span>Cita Rasa Gurih Mie Jawa Masak Arang</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-serif font-bold text-[#2B1B10] leading-tight">
                    Kenikmatan Autentik <span class="text-[#B3281A]">Mie Jawa</span> Spesial Masak Arang
                </h1>

                <p class="text-sm sm:text-base text-[#6B5B52] leading-relaxed max-w-xl">
                    {{ $profil->deskripsi ?? 'Disajikan hangat dengan kaldu ayam kampung gurih, racikan bumbu rempah ulekan segar, dan aroma sedap wajan anglo arang.' }}
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2">
                    <a href="{{ route('katalog') }}" class="px-6 py-3.5 bg-[#B3281A] hover:bg-[#8F1F14] text-white font-semibold rounded-2xl shadow-md min-h-[44px] flex items-center gap-2 transition cursor-pointer">
                        <span>Lihat Menu</span>
                        <span>→</span>
                    </a>

                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3.5 bg-white hover:bg-[#F5E8D3] border border-[#E5D7C3] text-[#2B1B10] font-semibold rounded-2xl shadow-xs min-h-[44px] flex items-center gap-2 transition">
                        <span>💬</span>
                        <span>Tanya via WhatsApp</span>
                    </a>
                </div>

                <!-- 3 Fitur Nilai Tambah -->
                <div class="pt-6 border-t border-[#F5E8D3] grid grid-cols-3 gap-4 text-left">
                    <div>
                        <div class="text-xs font-bold text-[#2B1B10]">🎖️ 100% Halal</div>
                        <div class="text-[11px] text-[#6B5B52] mt-0.5">Bahan Alami Higienis</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#2B1B10]">🔥 Anglo Arang</div>
                        <div class="text-[11px] text-[#6B5B52] mt-0.5">Wangi Smokey Khas</div>
                    </div>
                    <div>
                        <div class="text-xs font-bold text-[#2B1B10]">⏰ Buka Malam</div>
                        <div class="text-[11px] text-[#6B5B52] mt-0.5">18.00 – 22.00 WIB</div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Cuplikan Menu Terlaris Sesuai Mockup 165301 -->
            <div class="lg:col-span-5">
                @if ($menuUnggulan->isNotEmpty())
                    @php $unggulanUtama = $menuUnggulan->first(); @endphp
                    <div class="bg-white rounded-3xl p-5 shadow-xl border border-[#F5E8D3] max-w-md mx-auto">
                        <div class="relative aspect-4/3 rounded-2xl overflow-hidden mb-4 bg-[#FFF3E3]">
                            <span class="absolute top-3 left-3 bg-[#B3281A] text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase shadow-xs">
                                {{ $unggulanUtama->kategori }}
                            </span>
                            @if ($unggulanUtama->foto && (file_exists(public_path('storage/' . $unggulanUtama->foto)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($unggulanUtama->foto)))
                                <img src="{{ asset('storage/' . $unggulanUtama->foto) }}" alt="Foto sajian {{ $unggulanUtama->nama_menu }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-5xl bg-gradient-to-br from-[#FFF5E6] to-[#FFE8CC] text-[#8C7A70]">
                                    🍜
                                    <span class="text-xs font-semibold text-[#6B5B52] mt-2">{{ $unggulanUtama->nama_menu }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="px-2 pb-2">
                            <div class="flex items-center justify-between text-xs font-bold mb-1">
                                <span class="text-[#B3281A] uppercase tracking-wider">MENU PALING LARIS</span>
                                <span class="text-[#2B1B10] text-sm font-extrabold">Rp {{ number_format($unggulanUtama->harga, 0, ',', '.') }}</span>
                            </div>
                            <h3 class="text-lg font-serif font-bold text-[#2B1B10]">{{ $unggulanUtama->nama_menu }}</h3>
                            <p class="text-xs text-[#6B5B52] mt-1 line-clamp-2 leading-relaxed">
                                {{ $unggulanUtama->deskripsi }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

<!-- 2. Banner Promosi Aktif (Hanya jika is_aktif = true dan hari ini dalam periodenya) -->
@if ($promosiAktif)
    <section class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-[#B3281A] via-[#8F1F14] to-[#6E140C] rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    @if ($promosiAktif->banner && (file_exists(public_path('storage/' . $promosiAktif->banner)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($promosiAktif->banner)))
                        <div class="w-full sm:w-56 md:w-64 h-48 md:h-52 rounded-2xl overflow-hidden shadow-lg shrink-0 border-2 border-white/20 bg-black/20">
                            <img src="{{ asset('storage/' . $promosiAktif->banner) }}" alt="{{ $promosiAktif->judul }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="space-y-2 max-w-2xl flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-xs text-[#F2B84B] text-[11px] font-bold tracking-wider uppercase">
                            <span>🏷️ PROMO HARI INI</span>
                            <span>•</span>
                            <span>Berlaku s/d {{ \Carbon\Carbon::parse($promosiAktif->tanggal_selesai)->translatedFormat('d F Y') }}</span>
                        </div>
                        <h2 class="text-xl sm:text-3xl font-serif font-bold text-white">
                            {{ $promosiAktif->judul }}
                        </h2>
                        <p class="text-xs sm:text-sm text-white/90 leading-relaxed">
                            {{ $promosiAktif->deskripsi }}
                        </p>
                    </div>

                    @php
                        $klaimPromoUrl = "https://wa.me/{$waNumber}?text=" . urlencode("Halo Warung Mie Jawa, saya ingin mengklaim: {$promosiAktif->judul}");
                    @endphp
                    <a href="{{ $klaimPromoUrl }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3.5 bg-[#F2B84B] hover:bg-[#E5AA3D] text-[#2B1B10] font-bold rounded-2xl shadow-md min-h-[44px] flex items-center gap-2 transition shrink-0">
                        <span>Klaim Promo via WhatsApp</span>
                        <span>→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif

<!-- 3. Menu Unggulan Warung Sesuai Mockup 165408 -->
<section class="py-16 bg-white/50 border-y border-[#F5E8D3]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold text-[#B3281A] uppercase tracking-wider">✨ Pilihan Terfavorit</span>
                <h2 class="text-2xl sm:text-4xl font-serif font-bold text-[#2B1B10] mt-1">
                    4 Menu Unggulan Warung
                </h2>
                <p class="text-xs sm:text-sm text-[#6B5B52] mt-1">
                    Sajian andalan yang paling sering dicari pelanggan setia, diracik dengan bumbu rempah pilihan dan kaldu gurih.
                </p>
            </div>
            <a href="{{ route('katalog') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-[#B3281A] hover:text-[#8F1F14] transition min-h-[44px]">
                <span>Lihat Semua Menu</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($menuUnggulan as $menu)
                <x-kartu-menu :menu="$menu" mode="publik" />
            @endforeach
        </div>

    </div>
</section>

<!-- 4. Cuplikan Lokasi & Jam Operasional Sesuai Mockup 165424 -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold text-[#B3281A] uppercase tracking-wider">Kunjungi Kami</span>
            <h2 class="text-2xl sm:text-4xl font-serif font-bold text-[#2B1B10] mt-1">
                Lokasi Warung &amp; Jam Operasional
            </h2>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-1">
                Nikmati hidangan langsung di tempat dengan suasana warung tradisional yang hangat dan nyaman.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            
            <!-- Kartu Alamat & Jam Buka -->
            <div class="lg:col-span-6 space-y-4">
                <div class="p-5 bg-white rounded-3xl border border-[#F5E8D3] shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#FEF2F2] text-[#B3281A] flex items-center justify-center text-xl shrink-0">
                        📍
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-[#2B1B10]">Alamat Warung</h3>
                        <p class="text-xs text-[#6B5B52] mt-1 leading-relaxed">
                            {{ $profil->alamat ?? 'Jl. Sultan Abdurrahman, Mie Goreng Jawa, Pontianak, Kalimantan Barat' }}
                        </p>
                    </div>
                </div>

                <div class="p-5 bg-white rounded-3xl border border-[#F5E8D3] shadow-sm flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#FEF2F2] text-[#B3281A] flex items-center justify-center text-xl shrink-0">
                        ⏰
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-bold text-[#2B1B10]">Jam Operasional</h3>
                        <div class="text-xs text-[#6B5B52] mt-1.5 space-y-1">
                            <div class="flex justify-between">
                                <span>Senin – Sabtu:</span>
                                <span class="font-bold text-[#B3281A]">18.00 – 22.00 WIB</span>
                            </div>
                            <div class="flex justify-between border-t border-[#F5E8D3] pt-1">
                                <span>Minggu:</span>
                                <span class="font-bold text-red-600">Tutup / Libur</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ $gmapsUrl }}" target="_blank" rel="noopener noreferrer" class="px-5 py-3 bg-[#B3281A] hover:bg-[#8F1F14] text-white font-semibold rounded-2xl text-xs sm:text-sm min-h-[44px] flex items-center gap-2 transition shadow-sm">
                        <span>Buka Petunjuk Arah</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>

                    <a href="{{ route('lokasi') }}" class="px-5 py-3 bg-white hover:bg-[#F5E8D3] border border-[#E5D7C3] text-[#2B1B10] font-semibold rounded-2xl text-xs sm:text-sm min-h-[44px] flex items-center gap-2 transition">
                        <span>Halaman Lokasi Lengkap</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- Peta Embed Interaktif Google Maps -->
            <div class="lg:col-span-6">
                <div class="bg-white p-3 rounded-3xl border border-[#F5E8D3] shadow-md">
                    <div class="aspect-4/3 rounded-2xl overflow-hidden bg-gray-100">
                        <iframe 
                            src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&hl=id&z=16&output=embed"
                            class="w-full h-full border-0"
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Warung Mie Jawa Masak Anglo Arang">
                        </iframe>
                    </div>
                    <div class="p-3 text-center text-xs text-[#6B5B52] flex items-center justify-center gap-2">
                        <span>🚗</span>
                        <span>Parkir luas motor &amp; mobil • Ruang makan semi-outdoor tradisional</span>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection
