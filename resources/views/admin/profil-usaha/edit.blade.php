@extends('layouts.admin')

@section('title', 'Pengaturan Profil Usaha')
@section('header_title', 'Pengaturan Profil Usaha')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header Informasi Warung Sesuai Mockup -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3]">
            <div class="flex flex-wrap items-center gap-2 mb-2">
                <span class="text-[11px] font-bold tracking-wider text-[#B3281A] uppercase">
                    INFORMASI WARUNG
                </span>
                <span
                    class="text-[10px] font-bold tracking-wider text-[#995200] uppercase bg-[#FEF3C7] px-2.5 py-0.5 rounded-full border border-[#FCD34D]">
                    Akses Pengelola
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#2B1B10]">
                Pengaturan Profil Usaha
            </h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-1">
                Kelola data cabang, titik koordinat Google Maps, informasi kontak pemesanan, dan identitas resmi UMKM Mie
                Jawa.
            </p>

            @if ($profil->user)
                <div class="mt-4 pt-4 border-t border-[#F5E8D3] flex items-center gap-2 text-xs text-[#8C7A70]">
                    <span>🕒 Terakhir diperbarui oleh:</span>
                    <span class="font-bold text-[#2B1B10]">{{ $profil->user->nama }}</span>
                    <span>pada {{ $profil->updated_at->translatedFormat('d F Y, H:i') }} WIB</span>
                </div>
            @endif
        </div>

        <!-- Formulir Edit Profil Usaha -->
        <form action="{{ route('admin.profil-usaha.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Kartu 1: Identitas & Slogan Warung -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#F5E8D3] space-y-5">
                <div class="flex items-center gap-2.5 pb-3 border-b border-[#F5E8D3]">
                    <div
                        class="w-8 h-8 rounded-xl bg-[#FFF8EE] text-[#B3281A] flex items-center justify-center font-bold text-sm border border-[#F5E8D3]">
                        🏪
                    </div>
                    <h2 class="text-sm sm:text-base font-serif font-bold text-[#2B1B10]">
                        Identitas &amp; Slogan Warung
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Usaha -->
                    <div class="space-y-1.5">
                        <label for="nama_usaha" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                            Nama Usaha / Warung <span class="text-[#B3281A]">*</span>
                        </label>
                        <input type="text" id="nama_usaha" name="nama_usaha"
                            value="{{ old('nama_usaha', $profil->nama_usaha) }}" required placeholder="Mie Jawa"
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('nama_usaha') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                        @error('nama_usaha')
                            <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slogan / Deskripsi Singkat -->
                    <div class="space-y-1.5">
                        <label for="deskripsi" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                            Slogan / Tagline Usaha
                        </label>
                        <input type="text" id="deskripsi" name="deskripsi"
                            value="{{ old('deskripsi', $profil->deskripsi) }}"
                            placeholder="Cita Rasa Gurih Mie Jawa Masak Arang"
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('deskripsi') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                        @error('deskripsi')
                            <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Unggah Logo Resmi -->
                <div class="space-y-2 pt-2">
                    <label class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                        Logo Resmi Warung (Opsional)
                    </label>
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-2xl border border-dashed border-[#E5D7C3] bg-[#FFFBF5]">
                        <!-- Preview Container -->
                        <div id="logo-preview-box"
                            class="w-20 h-20 rounded-2xl border border-[#E5D7C3] bg-white overflow-hidden flex items-center justify-center text-xs text-[#A6998F] shrink-0 shadow-sm">
                            @if ($profil->logo)
                                <img id="logo-preview-img" src="{{ asset('storage/' . $profil->logo) }}"
                                    alt="Logo {{ $profil->nama_usaha }}" class="w-full h-full object-contain p-1">
                                <span id="logo-placeholder-text" class="hidden">Logo</span>
                            @else
                                <span id="logo-placeholder-text" class="text-xl">🍜</span>
                                <img id="logo-preview-img" src="" alt="Pratinjau Logo"
                                    class="w-full h-full object-contain p-1 hidden">
                            @endif
                        </div>

                        <div class="space-y-1 text-xs text-[#6B5B52] flex-1">
                            <input type="file" id="logo" name="logo" accept="image/jpeg,image/png,image/webp"
                                class="block w-full text-xs text-[#2B1B10] file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#B3281A] file:text-white hover:file:bg-[#941F14] file:cursor-pointer cursor-pointer">
                            <p class="text-[11px] text-[#8C7A70]">Maksimal 2 MB (JPG, PNG, atau WebP). Kosongkan jika tetap
                                memakai logo lama.</p>
                            @error('logo')
                                <p class="text-[11px] text-rose-600 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu 2: Kontak & Saluran Pemesanan -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#F5E8D3] space-y-5">
                <div class="flex items-center gap-2.5 pb-3 border-b border-[#F5E8D3]">
                    <div
                        class="w-8 h-8 rounded-xl bg-[#FFF8EE] text-[#B3281A] flex items-center justify-center font-bold text-sm border border-[#F5E8D3]">
                        📞
                    </div>
                    <h2 class="text-sm sm:text-base font-serif font-bold text-[#2B1B10]">
                        Kontak &amp; Saluran Pemesanan
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nomor Telepon / WhatsApp -->
                    <div class="space-y-1.5">
                        <label for="no_whatsapp" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                            Nomor WhatsApp Pemesanan <span class="text-[#B3281A]">*</span>
                        </label>
                        <input type="text" id="no_whatsapp" name="no_whatsapp"
                            value="{{ old('no_whatsapp', $profil->no_whatsapp) }}" required placeholder="081549077231"
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('no_whatsapp') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                        <p class="text-[11px] text-[#8C7A70]">Tautan WhatsApp publik: <span
                                class="font-mono text-[#B3281A]">https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $profil->no_whatsapp)) }}</span>
                        </p>
                        @error('no_whatsapp')
                            <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Akun Instagram -->
                    <div class="space-y-1.5">
                        <label for="instagram" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                            Akun Instagram Warung
                        </label>
                        <input type="text" id="instagram" name="instagram"
                            value="{{ old('instagram', $profil->instagram) }}" placeholder="@miejawa.official"
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('instagram') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                        @error('instagram')
                            <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Kartu 3: Alamat Fisik & Peta -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#F5E8D3] space-y-5">
                <div class="flex items-center gap-2.5 pb-3 border-b border-[#F5E8D3]">
                    <div
                        class="w-8 h-8 rounded-xl bg-[#FFF8EE] text-[#B3281A] flex items-center justify-center font-bold text-sm border border-[#F5E8D3]">
                        📍
                    </div>
                    <h2 class="text-sm sm:text-base font-serif font-bold text-[#2B1B10]">
                        Alamat Fisik &amp; Koordinat Google Maps
                    </h2>
                </div>

                <!-- Alamat Lengkap -->
                <div class="space-y-1.5">
                    <label for="alamat" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                        Alamat Lengkap Jalan <span class="text-[#B3281A]">*</span>
                    </label>
                    <textarea id="alamat" name="alamat" rows="3" required
                        placeholder="Jl. Sultan Abdurrahman, Mie Goreng Jawa, Pontianak"
                        class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('alamat') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10">{{ old('alamat', $profil->alamat) }}</textarea>
                    @error('alamat')
                        <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Koordinat Latitude & Longitude -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label for="latitude" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                            Latitude (Garis Lintang)
                        </label>
                        <input type="number" step="any" id="latitude" name="latitude"
                            value="{{ old('latitude', $profil->latitude) }}" placeholder="-0.035500"
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('latitude') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                        @error('latitude')
                            <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="longitude" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                            Longitude (Garis Bujur)
                        </label>
                        <input type="number" step="any" id="longitude" name="longitude"
                            value="{{ old('longitude', $profil->longitude) }}" placeholder="109.331000"
                            class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('longitude') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                        @error('longitude')
                            <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Bantuan Titik & Pratinjau Peta Interaktif -->
                <div class="space-y-3 pt-2">
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" id="btn-set-abdurrahman"
                            class="px-3 py-1.5 rounded-xl bg-[#FFF8EE] hover:bg-[#F5E8D3] border border-[#E5D7C3] text-xs font-semibold text-[#B3281A] transition cursor-pointer flex items-center gap-1.5 min-h-[44px]">
                            <span>📍</span>
                            <span>Titik Akurat Jl. Sultan Abdurrahman (-0.035500, 109.331000)</span>
                        </button>
                        <button type="button" id="btn-detect-gps"
                            class="px-3 py-1.5 rounded-xl bg-[#FFF8EE] hover:bg-[#F5E8D3] border border-[#E5D7C3] text-xs font-semibold text-[#2B1B10] transition cursor-pointer flex items-center gap-1.5 min-h-[44px]">
                            <span>🛰️</span>
                            <span>Gunakan Lokasi Perangkat Saya (GPS)</span>
                        </button>
                    </div>

                    <div class="p-4 rounded-2xl bg-[#FFF8EE] border border-[#E5D7C3] space-y-3">
                        <div class="flex flex-wrap items-center justify-between gap-2 text-xs">
                            <span class="text-[#6B5B52] font-medium">Pratinjau peta embed Google Maps langsung:</span>
                            <a id="link-gmaps-external"
                                href="https://maps.google.com/?q={{ $profil->latitude ?? -0.035500 }},{{ $profil->longitude ?? 109.331000 }}"
                                target="_blank"
                                class="font-semibold text-[#B3281A] hover:underline flex items-center gap-1">
                                Buka di Google Maps ↗
                            </a>
                        </div>
                        <div class="aspect-16/9 rounded-xl overflow-hidden bg-gray-100 border border-[#E5D7C3]">
                            <iframe id="map-preview-iframe"
                                src="https://maps.google.com/maps?q={{ $profil->latitude ?? -0.035500 }},{{ $profil->longitude ?? 109.331000 }}&hl=id&z=17&output=embed"
                                class="w-full h-full border-0" loading="lazy" title="Pratinjau Peta Google Maps">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu 4: Jadwal Jam Operasional -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 shadow-sm border border-[#F5E8D3] space-y-5">
                <div class="flex items-center gap-2.5 pb-3 border-b border-[#F5E8D3]">
                    <div
                        class="w-8 h-8 rounded-xl bg-[#FFF8EE] text-[#B3281A] flex items-center justify-center font-bold text-sm border border-[#F5E8D3]">
                        ⏰
                    </div>
                    <h2 class="text-sm sm:text-base font-serif font-bold text-[#2B1B10]">
                        Jadwal Jam Operasional Warung
                    </h2>
                </div>

                <div class="space-y-1.5">
                    <label for="jam_operasional" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                        Jadwal Buka &amp; Tutup (Format Bebas per Baris)
                    </label>
                    <textarea id="jam_operasional" name="jam_operasional" rows="3"
                        placeholder="Senin - Sabtu: 17.00 - 23.00 WIB&#10;Minggu: Tutup / Libur"
                        class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('jam_operasional') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 font-mono text-xs">{{ old('jam_operasional', $profil->jam_operasional) }}</textarea>
                    <p class="text-[11px] text-[#8C7A70]">Jadwal ini akan langsung ditampilkan di halaman kontak dan kaki
                        halaman (footer) website publik.</p>
                    @error('jam_operasional')
                        <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="flex items-center justify-end">
                <button type="submit"
                    class="w-full sm:w-auto px-8 py-3 rounded-xl bg-[#B3281A] hover:bg-[#941F14] text-white font-bold text-xs sm:text-sm shadow-md transition min-h-[44px] flex items-center justify-center cursor-pointer">
                    Simpan Informasi Profil
                </button>
            </div>

        </form>

    </div>

    <!-- Script Pratinjau Logo -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const logoInput = document.getElementById('logo');
            const previewImg = document.getElementById('logo-preview-img');
            const placeholderText = document.getElementById('logo-placeholder-text');

            if (logoInput) {
                logoInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (event) {
                            previewImg.src = event.target.result;
                            previewImg.classList.remove('hidden');
                            if (placeholderText) placeholderText.classList.add('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
            // Pratinjau Interaktif Koordinat Google Maps
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const mapIframe = document.getElementById('map-preview-iframe');
            const externalLink = document.getElementById('link-gmaps-external');
            const btnPreset = document.getElementById('btn-set-abdurrahman');
            const btnGps = document.getElementById('btn-detect-gps');

            function updateMapPreview() {
                if (!latInput || !lngInput || !mapIframe) return;
                const lat = latInput.value.trim();
                const lng = lngInput.value.trim();
                if (lat && lng && !isNaN(lat) && !isNaN(lng)) {
                    mapIframe.src = `https://maps.google.com/maps?q=${lat},${lng}&hl=id&z=17&output=embed`;
                    if (externalLink) {
                        externalLink.href = `https://maps.google.com/?q=${lat},${lng}`;
                    }
                }
            }

            if (latInput && lngInput) {
                latInput.addEventListener('input', updateMapPreview);
                lngInput.addEventListener('input', updateMapPreview);
            }

            if (btnPreset) {
                btnPreset.addEventListener('click', function () {
                    if (latInput) latInput.value = '-0.035500';
                    if (lngInput) lngInput.value = '109.331000';
                    updateMapPreview();
                });
            }

            if (btnGps) {
                btnGps.addEventListener('click', function () {
                    if (navigator.geolocation) {
                        btnGps.innerHTML = '<span>⏳</span><span>Mendeteksi koordinat...</span>';
                        navigator.geolocation.getCurrentPosition(
                            function (position) {
                                if (latInput) latInput.value = position.coords.latitude.toFixed(6);
                                if (lngInput) lngInput.value = position.coords.longitude.toFixed(6);
                                updateMapPreview();
                                btnGps.innerHTML = '<span>🛰️</span><span>Gunakan Lokasi Perangkat Saya (GPS)</span>';
                            },
                            function (error) {
                                alert('Gagal mendeteksi koordinat GPS: ' + error.message);
                                btnGps.innerHTML = '<span>🛰️</span><span>Gunakan Lokasi Perangkat Saya (GPS)</span>';
                            },
                            { enableHighAccuracy: true, timeout: 10000 }
                        );
                    } else {
                        alert('Fitur Geolocation tidak didukung di peramban ini.');
                    }
                });
            }
        });
    </script>
@endsection