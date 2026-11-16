<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Dasbor Pengelolaan - Mie Jawa Masak Anglo Arang</title>
    <meta name="description" content="Portal masuk pengelolaan operasional dan eksekutif UMKM Mie Jawa.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FFF8EE] text-[#2B1B10] min-h-screen flex items-center justify-center p-4 sm:p-6 font-sans">
    <div class="w-full max-w-lg bg-white rounded-3xl shadow-xl border border-[#F5E8D3] p-6 sm:p-8">

        <!-- Baris Atas: Kembali ke Website & Label Portal -->
        <div class="flex items-center justify-between pb-4 border-b border-[#F7EFE2] mb-6">
            <a href="{{ route('beranda') }}"
                class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-[#6B5B52] hover:text-[#B3281A] transition min-h-[44px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span>Kembali ke Website</span>
            </a>
            <span
                class="inline-block bg-[#FEE2E2] text-[#B3281A] text-[11px] font-bold tracking-wider px-3 py-1 rounded-full uppercase">
                PORTAL AKTOR SISTEM
            </span>
        </div>

        <!-- Logo dan Judul Halaman -->
        <div class="text-center mb-6">
            <div
                class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#2B1B10] text-[#F2B84B] shadow-md mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#2B1B10]">Masuk Dasbor Pengelolaan</h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-2 max-w-md mx-auto leading-relaxed">
                Sistem memisahkan peran: <span class="font-semibold text-[#2B1B10]">Pemilik Usaha (Owner)</span> untuk
                laporan omzet & profil usaha; <span class="font-semibold text-[#2B1B10]">Administrator (Admin)</span>
                untuk operasional menu & stok harian.
            </p>
        </div>

        <!-- Notifikasi Status / Pesan Keluar -->
        <x-alert />

        <!-- Pilihan Bantuan Peran (Pengisian Cepat) -->
        <div class="mb-5">
            <label class="block text-xs font-semibold text-[#2B1B10] mb-2">Pilih Peran untuk Masuk:</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button type="button" id="role-owner-btn" onclick="selectRole('owner')"
                    class="text-left p-3 rounded-2xl border-2 border-[#B3281A] bg-[#FEF2F2] flex items-center justify-between min-h-[44px] transition">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-8 h-8 rounded-xl bg-[#B3281A] text-white flex items-center justify-center font-bold text-xs shrink-0">
                            👑
                        </div>
                        <div>
                            <div class="text-xs font-bold text-[#B3281A]">Pemilik Usaha</div>
                            <div class="text-[10px] text-[#8F1F14]">Eksekutif & Laporan Omzet</div>
                        </div>
                    </div>
                    <span id="role-owner-check" class="text-[#B3281A] font-bold text-sm">✓</span>
                </button>

                <button type="button" id="role-admin-btn" onclick="selectRole('admin')"
                    class="text-left p-3 rounded-2xl border-2 border-gray-200 bg-white hover:border-[#F2B84B] flex items-center justify-between min-h-[44px] transition">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-8 h-8 rounded-xl bg-gray-100 text-[#2B1B10] flex items-center justify-center font-bold text-xs shrink-0">
                            🛡️
                        </div>
                        <div>
                            <div class="text-xs font-bold text-[#2B1B10]">Administrator</div>
                            <div class="text-[10px] text-[#6B5B52]">Operasional Harian Menu</div>
                        </div>
                    </div>
                    <span id="role-admin-check" class="text-gray-300 font-bold text-sm hidden">✓</span>
                </button>
            </div>
        </div>

        <!-- Form Autentikasi -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Input Alamat Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-[#2B1B10] mb-1.5">Alamat Email Aktor</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email', 'pemilik@miejawa.com') }}"
                        required autocomplete="email" autofocus
                        class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#E5D7C3] rounded-xl text-xs sm:text-sm text-[#2B1B10] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#B3281A] focus:border-transparent min-h-[44px]"
                        placeholder="contoh: pemilik@miejawa.com">
                </div>
                @error('email')
                    <p class="text-[11px] text-[#B3281A] font-medium mt-1.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Input Kata Sandi -->
            <div>
                <label for="password" class="block text-xs font-semibold text-[#2B1B10] mb-1.5">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                        class="w-full pl-10 pr-12 py-2.5 bg-white border border-[#E5D7C3] rounded-xl text-xs sm:text-sm text-[#2B1B10] placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#B3281A] focus:border-transparent min-h-[44px]"
                        placeholder="••••••••">
                    <button type="button" id="toggle-password" onclick="togglePasswordVisibility()"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-[#B3281A] cursor-pointer min-h-[44px] min-w-[44px] justify-center"
                        aria-label="Lihat atau sembunyikan kata sandi" title="Lihat/Sembunyikan Kata Sandi">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-[11px] text-[#B3281A] font-medium mt-1.5 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Ingat Saya -->
            <div class="flex items-center justify-between text-xs text-[#6B5B52]">
                <label class="flex items-center gap-2 cursor-pointer min-h-[44px]">
                    <input type="checkbox" name="remember"
                        class="w-4 h-4 text-[#B3281A] border-[#E5D7C3] rounded focus:ring-[#B3281A]">
                    <span>Ingat sesi masuk di peramban ini</span>
                </label>
            </div>

            <!-- Tombol Submit Masuk -->
            <button type="submit" id="submit-btn"
                class="w-full bg-[#B3281A] hover:bg-[#8F1F14] text-white font-semibold py-3 px-4 rounded-xl shadow-md min-h-[44px] flex items-center justify-center gap-2 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span id="submit-btn-text">Masuk sebagai Pemilik Usaha</span>
            </button>
        </form>

    </div>

    <!-- Script Pemilihan Cepat Peran & Toggle Sandi -->
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeSlashIcon.classList.add('hidden');
                eyeIcon.classList.remove('hidden');
            }
        }

        function selectRole(role) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const submitBtnText = document.getElementById('submit-btn-text');
            const ownerBtn = document.getElementById('role-owner-btn');
            const adminBtn = document.getElementById('role-admin-btn');
            const ownerCheck = document.getElementById('role-owner-check');
            const adminCheck = document.getElementById('role-admin-check');

            if (role === 'owner') {
                emailInput.value = 'pemilik@miejawa.com';
                submitBtnText.textContent = 'Masuk sebagai Pemilik Usaha';

                ownerBtn.className = 'text-left p-3 rounded-2xl border-2 border-[#B3281A] bg-[#FEF2F2] flex items-center justify-between min-h-[44px] transition';
                adminBtn.className = 'text-left p-3 rounded-2xl border-2 border-gray-200 bg-white hover:border-[#F2B84B] flex items-center justify-between min-h-[44px] transition';
                ownerCheck.classList.remove('hidden');
                adminCheck.classList.add('hidden');
            } else {
                emailInput.value = 'admin@miejawa.com';
                submitBtnText.textContent = 'Masuk sebagai Administrator';

                adminBtn.className = 'text-left p-3 rounded-2xl border-2 border-[#B3281A] bg-[#FEF2F2] flex items-center justify-between min-h-[44px] transition';
                ownerBtn.className = 'text-left p-3 rounded-2xl border-2 border-gray-200 bg-white hover:border-[#F2B84B] flex items-center justify-between min-h-[44px] transition';
                adminCheck.classList.remove('hidden');
                ownerCheck.classList.add('hidden');
            }

            if (passwordInput) {
                passwordInput.focus();
            }
        }
    </script>
</body>

</html>