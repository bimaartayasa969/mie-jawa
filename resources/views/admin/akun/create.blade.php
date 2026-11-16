@extends('layouts.admin')

@section('title', 'Tambah Akun Administrator')
@section('header_title', 'Tambah Akun Administrator')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    <!-- Tombol Kembali & Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.akun.index') }}"
            class="inline-flex items-center gap-2 text-xs font-semibold text-[#8C7A70] hover:text-[#B3281A] transition min-h-[44px]">
            <span>←</span>
            <span>Kembali ke Daftar Akun</span>
        </a>
        <span class="inline-block text-[11px] font-bold tracking-wider text-[#995200] uppercase bg-[#FEF3C7] px-2.5 py-1 rounded-full border border-[#FCD34D]">
            Khusus Owner
        </span>
    </div>

    <!-- Formulir Pendaftaran Akun -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3]">
        <div class="pb-5 mb-6 border-b border-[#F5E8D3]">
            <h1 class="text-xl sm:text-2xl font-serif font-bold text-[#2B1B10]">Tambah Akun Administrator Baru</h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-1">
                Daftarkan akun staf pengelola warung agar dapat memperbarui daftar menu sajian dan harga.
            </p>
        </div>

        <form action="{{ route('admin.akun.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Lengkap -->
            <div class="space-y-1.5">
                <label for="nama" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                    Nama Lengkap Staf <span class="text-[#B3281A]">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                    placeholder="Contoh: Rian Pratama (Staf Dapur)"
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('nama') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                @error('nama')
                    <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat Email -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                    Alamat Email Login <span class="text-[#B3281A]">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    placeholder="staf@miejawa.com"
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                @error('email')
                    <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kata Sandi -->
            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                    Kata Sandi Awal <span class="text-[#B3281A]">*</span>
                </label>
                <input type="password" id="password" name="password" required minlength="8"
                    placeholder="Minimal 8 karakter"
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                <p class="text-[11px] text-[#8C7A70]">Kata sandi akan otomatis di-hash dengan standar keamanan Bcrypt.</p>
                @error('password')
                    <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan Hak Akses Peran -->
            <div class="p-4 rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-900 text-xs space-y-1">
                <div class="font-bold flex items-center gap-1.5">
                    <span>🛡️</span>
                    <span>Hak Akses Peran: Administrator (Admin)</span>
                </div>
                <p class="text-[11px] text-emerald-800">
                    Akun ini dapat masuk ke panel pengelolaan menu sajian (tambah sajian baru, ganti harga, ubah ketersediaan bahan, dan foto menu). Akun ini tidak dapat mengakses promosi, profil warung, atau pengelolaan akun lain.
                </p>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 border-t border-[#F5E8D3] flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('admin.akun.index') }}"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-[#E5D7C3] hover:bg-stone-100 text-[#2B1B10] font-semibold text-xs sm:text-sm text-center transition min-h-[44px] flex items-center justify-center">
                    Batal
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#B3281A] hover:bg-[#941F14] text-white font-bold text-xs sm:text-sm shadow-sm transition min-h-[44px] flex items-center justify-center cursor-pointer">
                    Daftarkan Akun Admin
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

