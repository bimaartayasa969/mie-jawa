@extends('layouts.app')

@section('title', 'Kontak & Informasi Warung - Mie Jawa')
@section('description', 'Hubungi pengelola warung Mie Jawa Pontianak via WhatsApp atau media sosial. Kirim pertanyaan menu, pesanan porsi banyak, atau reservasi meja.')

@php
    $noWa = $profil && $profil->no_whatsapp ? $profil->no_whatsapp : '0815 4907 7231';
    $waClean = preg_replace('/[^0-9]/', '', $noWa);
    if (str_starts_with($waClean, '0')) {
        $waClean = '62' . substr($waClean, 1);
    }
    $ig = $profil && $profil->instagram ? $profil->instagram : '@miejawa.official';
    $igClean = ltrim($ig, '@');
    $alamat = $profil && $profil->alamat ? $profil->alamat : 'Jl. Sultan Abdurrahman, Mie Goreng Jawa, Pontianak, Kalimantan Barat';
    $namaUsaha = $profil && $profil->nama_usaha ? $profil->nama_usaha : 'Mie Jawa Masak Anglo Arang';
@endphp

@section('content')
<section class="py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Halaman Kontak Sesuai Mockup 165533 -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-bold text-[#B3281A] uppercase tracking-wider">Hubungi Pemilik Usaha</span>
            <h1 class="text-3xl sm:text-5xl font-serif font-bold text-[#2B1B10] mt-1.5">
                Kontak &amp; Informasi Warung
            </h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-2 leading-relaxed">
                Punya pertanyaan tentang menu, pemesanan porsi banyak untuk acara, atau reservasi meja? Kami siap melayani Anda melalui WhatsApp dan media sosial.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Kiri: 3 Kartu Saluran Kontak -->
            <div class="lg:col-span-6 space-y-4">
                
                <!-- Kartu 1: Telepon & WhatsApp -->
                <div class="bg-white rounded-3xl p-6 border border-[#F5E8D3] shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                            📞
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-emerald-700">Respon Cepat &amp; Pemesanan</span>
                            <h2 class="text-base font-serif font-bold text-[#2B1B10]">Telepon &amp; WhatsApp</h2>
                            <div class="text-base sm:text-lg font-bold text-[#2B1B10] mt-0.5">{{ $noWa }}</div>
                            <p class="text-[11px] text-[#6B5B52] mt-0.5">Aktif setiap hari operasional (18.00 – 22.00 WIB)</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 sm:flex-col sm:items-stretch shrink-0">
                        <a href="tel:{{ $waClean }}" class="px-4 py-2 bg-white border border-[#E5D7C3] hover:border-[#B3281A] text-[#2B1B10] text-xs font-semibold rounded-xl min-h-[44px] flex items-center justify-center gap-1.5 transition">
                            <span>📞</span>
                            <span>Telepon</span>
                        </a>
                        <a href="https://wa.me/{{ $waClean }}?text={{ urlencode('Halo Warung Mie Jawa, saya ingin bertanya.') }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold rounded-xl min-h-[44px] flex items-center justify-center gap-1.5 transition">
                            <span>💬</span>
                            <span>Chat WA</span>
                        </a>
                    </div>
                </div>

                <!-- Kartu 2: Media Sosial Instagram -->
                <div class="bg-white rounded-3xl p-6 border border-[#F5E8D3] shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl shrink-0">
                            📷
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-rose-700">Media Sosial</span>
                            <h2 class="text-base font-serif font-bold text-[#2B1B10]">Instagram Warung</h2>
                            <div class="text-sm font-bold text-[#2B1B10] mt-0.5">{{ $ig }}</div>
                            <p class="text-[11px] text-[#6B5B52] mt-0.5">Lihat suasana harian, video memasak, dan promo terbaru</p>
                        </div>
                    </div>

                    <a href="https://instagram.com/{{ $igClean }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 bg-[#B3281A] hover:bg-[#8F1F14] text-white text-xs font-semibold rounded-xl min-h-[44px] flex items-center justify-center gap-1.5 transition shrink-0">
                        <span>Kunjungi</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>

                <!-- Kartu 3: Alamat Fisik Warung -->
                <div class="bg-white rounded-3xl p-6 border border-[#F5E8D3] shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl shrink-0">
                            📍
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold uppercase tracking-wider text-amber-800">Alamat Fisik</span>
                            <h2 class="text-base font-serif font-bold text-[#2B1B10]">{{ $namaUsaha }}</h2>
                            <p class="text-xs text-[#6B5B52] mt-1 leading-relaxed">{{ $alamat }}</p>
                        </div>
                    </div>

                    <a href="{{ route('lokasi') }}" class="px-5 py-2.5 bg-white border border-[#E5D7C3] hover:border-[#B3281A] text-[#2B1B10] text-xs font-semibold rounded-xl min-h-[44px] flex items-center justify-center gap-1.5 transition shrink-0">
                        <span>Peta</span>
                        <span>→</span>
                    </a>
                </div>

            </div>

            <!-- Kolom Kanan: Formulir Kirim Pesan Langsung ke WhatsApp -->
            <div class="lg:col-span-6">
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#F5E8D3] shadow-md">
                    <div class="mb-6">
                        <h2 class="text-xl sm:text-2xl font-serif font-bold text-[#2B1B10]">
                            Kirim Pesan Langsung ke WhatsApp
                        </h2>
                        <p class="text-xs text-[#6B5B52] mt-1.5 leading-relaxed">
                            Tulis pesan atau pertanyaan Anda di bawah ini, dan sistem akan langsung menghubungkannya ke chat WhatsApp pemilik warung.
                        </p>
                    </div>

                    <form id="wa-contact-form" onsubmit="handleSendWa(event)" class="space-y-4">
                        <div>
                            <label for="wa-nama" class="block text-xs font-semibold text-[#2B1B10] mb-1.5">Nama Anda</label>
                            <input type="text" id="wa-nama" required placeholder="Contoh: Budi Santoso"
                                class="w-full px-4 py-3 bg-[#FFF8EE]/50 border border-[#E5D7C3] rounded-2xl text-xs sm:text-sm text-[#2B1B10] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#B3281A] focus:bg-white min-h-[44px]">
                        </div>

                        <div>
                            <label for="wa-pesan" class="block text-xs font-semibold text-[#2B1B10] mb-1.5">Pesan atau Pertanyaan</label>
                            <textarea id="wa-pesan" rows="4" required placeholder="Tuliskan pertanyaan Anda mengenai ketersediaan menu, reservasi meja, atau pesanan katering..."
                                class="w-full px-4 py-3 bg-[#FFF8EE]/50 border border-[#E5D7C3] rounded-2xl text-xs sm:text-sm text-[#2B1B10] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#B3281A] focus:bg-white resize-none"></textarea>
                        </div>

                        <button type="submit" 
                            class="w-full bg-[#B3281A] hover:bg-[#8F1F14] text-white font-semibold py-3.5 px-6 rounded-2xl shadow-md min-h-[44px] flex items-center justify-center gap-2 transition text-xs sm:text-sm cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12 0 2.155.57 4.179 1.569 5.924l-1.569 5.736 5.894-1.545c1.706.945 3.663 1.485 5.75 1.485 6.627 0 12-5.373 12-12 0-6.627-5.373-12-12-12z"/>
                            </svg>
                            <span>Kirim via WhatsApp</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</section>

<script>
    function handleSendWa(event) {
        event.preventDefault();
        const nama = document.getElementById('wa-nama').value.trim();
        const pesan = document.getElementById('wa-pesan').value.trim();
        const targetNumber = '{{ $waClean }}';

        const teksFormatted = `Halo Warung Mie Jawa, saya ${nama}.\n\n${pesan}`;
        const url = `https://wa.me/${targetNumber}?text=${encodeURIComponent(teksFormatted)}`;
        
        window.open(url, '_blank');
    }
</script>
@endsection
