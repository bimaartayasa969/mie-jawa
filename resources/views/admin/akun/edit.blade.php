@extends('layouts.admin')

@section('title', 'Ubah Data Akun')
@section('header_title', 'Ubah Data Akun')

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

    <!-- Formulir Ubah Akun -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3]">
        <div class="pb-5 mb-6 border-b border-[#F5E8D3]">
            <h1 class="text-xl sm:text-2xl font-serif font-bold text-[#2B1B10]">Ubah Data Akun</h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-1">
                Perbarui nama lengkap, alamat email login, atau ubah kata sandi staf.
            </p>
        </div>

        <form action="{{ route('admin.akun.update', $akun) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Identitas Akun -->
            <div class="p-3.5 rounded-2xl border {{ $akun->isOwner() ? 'bg-[#FEF2F2] border-[#FCA5A5]' : 'bg-emerald-50 border-emerald-200' }} flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg {{ $akun->isOwner() ? 'bg-[#B3281A] text-white' : 'bg-emerald-700 text-white' }} shrink-0">
                    {{ $akun->isOwner() ? '👑' : '🛡️' }}
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-wider {{ $akun->isOwner() ? 'text-[#B3281A]' : 'text-emerald-800' }}">
                        Tipe Akun: {{ $akun->isOwner() ? 'Pemilik Usaha (Owner Utama)' : 'Administrator Staf' }}
                    </span>
                    <div class="text-xs font-bold text-[#2B1B10]">
                        ID Pengguna #{{ $akun->id }} &bull; Bergabung sejak {{ $akun->created_at ? $akun->created_at->translatedFormat('d F Y') : '-' }}
                    </div>
                </div>
            </div>

            <!-- Nama Lengkap -->
            <div class="space-y-1.5">
                <label for="nama" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                    Nama Lengkap <span class="text-[#B3281A]">*</span>
                </label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $akun->nama) }}" required
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
                <input type="email" id="email" name="email" value="{{ old('email', $akun->email) }}" required
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('email') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                @error('email')
                    <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kata Sandi Baru -->
            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                    Kata Sandi Baru (Opsional)
                </label>
                <input type="password" id="password" name="password" minlength="8"
                    placeholder="Kosongkan jika tidak ingin mengubah kata sandi"
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('password') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                <p class="text-[11px] text-[#8C7A70]">Hanya isi jika ingin mengganti kata sandi. Minimal 8 karakter.</p>
                @error('password')
                    <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 border-t border-[#F5E8D3] flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('admin.akun.index') }}"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-[#E5D7C3] hover:bg-stone-100 text-[#2B1B10] font-semibold text-xs sm:text-sm text-center transition min-h-[44px] flex items-center justify-center">
                    Batal
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#B3281A] hover:bg-[#941F14] text-white font-bold text-xs sm:text-sm shadow-sm transition min-h-[44px] flex items-center justify-center cursor-pointer">
                    Perbarui Data Akun
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

