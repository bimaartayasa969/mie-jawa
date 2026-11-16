@extends('layouts.app')

@section('title', 'Lokasi Warung & Jam Operasional - Mie Jawa Pontianak')
@section('description', 'Temukan lokasi resmi warung Mie Jawa masak anglo arang di Pontianak. Panduan rute Google Maps embed, alamat lengkap, dan jam operasional buka.')

@php
    $lat = $profil->latitude ?? -0.03550000;
    $lng = $profil->longitude ?? 109.33100000;
    $alamat = $profil->alamat ?? 'Jl. Sultan Abdurrahman, Mie Goreng Jawa, Pontianak, Kalimantan Barat';
    $namaUsaha = $profil->nama_usaha ?? 'Mie Jawa Masak Anglo Arang';
    $gmapsUrl = "https://www.google.com/maps?q={$lat},{$lng}";
@endphp

@section('content')
<section class="py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Halaman Sesuai Mockup 165518 -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-bold text-[#B3281A] uppercase tracking-wider">Kunjungi Warung Kami</span>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-[#2B1B10] mt-1.5">
                Lokasi &amp; Jam Operasional
            </h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-2 leading-relaxed">
                Kami siap menyajikan hidangan bakmi Jawa hangat dalam suasana tradisional yang nyaman bagi Anda dan keluarga.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Kiri: Peta Google Maps Embed Interaktif Sesuai Koordinat Database -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-4 border border-[#F5E8D3] shadow-md space-y-4">
                    <div class="relative aspect-4/3 sm:aspect-16/10 rounded-2xl overflow-hidden bg-gray-100">
                        <iframe 
                            src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&hl=id&z=17&output=embed"
                            class="w-full h-full border-0"
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta Lokasi {{ $namaUsaha }}">
                        </iframe>

                        <!-- Tombol Pintas Google Maps di Atas Peta -->
                        <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between pointer-events-none">
                            <a href="{{ $gmapsUrl }}" target="_blank" rel="noopener noreferrer" 
                                class="pointer-events-auto px-4 py-2.5 bg-[#B3281A] hover:bg-[#8F1F14] text-white font-semibold text-xs rounded-xl shadow-md flex items-center gap-2 transition min-h-[44px]">
                                <span>Buka di Google Maps</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>

                            <span class="pointer-events-auto hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/95 backdrop-blur-xs text-[#2B1B10] font-bold text-xs rounded-xl shadow-sm border border-[#E5D7C3]">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Buka 18:00 – 22:00 WIB
                            </span>
                        </div>
                    </div>

                    <!-- Fasilitas & Akses Parkir -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        <div class="p-3 bg-[#FFF8EE] rounded-2xl border border-[#F5E8D3] flex items-center gap-2.5 text-xs text-[#2B1B10] font-medium">
                            <span class="text-base">🚗</span>
                            <span>Tersedia parkir mobil &amp; motor</span>
                        </div>
                        <div class="p-3 bg-[#FFF8EE] rounded-2xl border border-[#F5E8D3] flex items-center gap-2.5 text-xs text-[#2B1B10] font-medium">
                            <span class="text-base">🛵</span>
                            <span>Akses mudah di pusat Kota Pontianak</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Rincian Alamat Resmi & Jam Buka -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- Kartu Alamat Resmi -->
                <div class="bg-white rounded-3xl p-6 border border-[#F5E8D3] shadow-sm space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FEF2F2] text-[#B3281A] flex items-center justify-center text-xl shrink-0">
                            📍
                        </div>
                        <div class="space-y-1">
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-[#B3281A]">Alamat Resmi</span>
                            <h2 class="text-lg font-serif font-bold text-[#2B1B10]">{{ $namaUsaha }}</h2>
                            <p class="text-xs text-[#6B5B52] leading-relaxed">
                                {{ $alamat }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ $gmapsUrl }}" target="_blank" rel="noopener noreferrer" 
                        class="w-full bg-[#B3281A] hover:bg-[#8F1F14] text-white font-semibold py-3 px-4 rounded-2xl shadow-sm min-h-[44px] flex items-center justify-center gap-2 transition text-xs sm:text-sm cursor-pointer">
                        <span>Petunjuk Arah</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>

                <!-- Kartu Jam Operasional Warung -->
                <div class="bg-white rounded-3xl p-6 border border-[#F5E8D3] shadow-sm space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FEF2F2] text-[#B3281A] flex items-center justify-center text-xl shrink-0">
                            ⏰
                        </div>
                        <div class="space-y-0.5">
                            <h2 class="text-base font-serif font-bold text-[#2B1B10]">Jam Operasional Warung</h2>
                            <p class="text-xs text-[#6B5B52]">Melayani makan di tempat &amp; bungkus bawa pulang</p>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2 text-xs">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-[#FFF8EE] border border-[#F5E8D3]">
                            <div>
                                <div class="font-bold text-[#2B1B10]">Senin – Sabtu</div>
                                <div class="text-[11px] text-[#6B5B52]">Buka malam hari</div>
                            </div>
                            <span class="font-bold text-[#B3281A] text-sm">18.00 – 22.00 WIB</span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-xl bg-red-50/50 border border-red-100">
                            <div>
                                <div class="font-bold text-[#2B1B10]">Minggu</div>
                                <div class="text-[11px] text-[#6B5B52]">Hari istirahat mingguan</div>
                            </div>
                            <span class="font-bold text-red-600">Tutup / Libur</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
@endsection
