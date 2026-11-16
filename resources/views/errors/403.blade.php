<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Dibatasi (403) - Mie Jawa Masak Anglo Arang</title>
    <meta name="description" content="Akses ditolak. Halaman ini memerlukan wewenang khusus pemilik usaha (Owner) atau autentikasi yang sesuai.">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFF8EE] text-[#2B1B10] font-sans min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased">
    <div class="w-full max-w-md bg-white rounded-3xl p-6 sm:p-8 border border-[#F5E8D3] shadow-lg text-center space-y-5">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-[#FEF2F2] border border-[#FCA5A5] text-[#B3281A] flex items-center justify-center text-3xl shadow-sm">
            🛡️
        </div>
        
        <div>
            <span class="inline-block text-[11px] font-bold tracking-wider text-[#B3281A] uppercase bg-[#FEF2F2] px-2.5 py-1 rounded-full border border-[#FCA5A5] mb-2">
                Galat HTTP 403 &bull; Akses Terbatas
            </span>
            <h1 class="text-2xl font-serif font-bold text-[#2B1B10]">
                Wewenang Dibatasi
            </h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-2 leading-relaxed">
                Maaf, Anda tidak memiliki hak akses untuk membuka halaman ini. Fitur ini khusus disediakan untuk Pemilik Usaha (Owner).
            </p>
        </div>

        <div class="pt-4 border-t border-[#F5E8D3] flex flex-col sm:flex-row items-center justify-center gap-3">
            @auth
                <a href="{{ auth()->user()->isOwner() ? route('admin.dashboard') : route('admin.menu.index') }}"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-[#B3281A] hover:bg-[#941F14] text-white font-bold text-xs sm:text-sm shadow-sm transition min-h-[44px] flex items-center justify-center">
                    ← Kembali ke Dasbor Menu
                </a>
            @else
                <a href="{{ route('admin.login') }}"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-[#B3281A] hover:bg-[#941F14] text-white font-bold text-xs sm:text-sm shadow-sm transition min-h-[44px] flex items-center justify-center">
                    Masuk Akun Pengelola
                </a>
            @endauth

            <a href="{{ route('beranda') }}"
                class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-[#E5D7C3] hover:bg-stone-100 text-[#2B1B10] font-semibold text-xs sm:text-sm transition min-h-[44px] flex items-center justify-center">
                Ke Website Publik
            </a>
        </div>
    </div>
</body>
</html>

