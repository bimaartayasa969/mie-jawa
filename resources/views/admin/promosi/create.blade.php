@extends('layouts.admin')

@section('title', 'Tambah Banner Promosi')
@section('header_title', 'Tambah Banner Promosi')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Tombol Kembali & Header -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.promosi.index') }}"
            class="inline-flex items-center gap-2 text-xs font-semibold text-[#8C7A70] hover:text-[#B3281A] transition min-h-[44px]">
            <span>←</span>
            <span>Kembali ke Daftar Promosi</span>
        </a>
        <span class="inline-block text-[11px] font-bold tracking-wider text-[#995200] uppercase bg-[#FEF3C7] px-2.5 py-1 rounded-full border border-[#FCD34D]">
            Akses Pengelola
        </span>
    </div>

    <!-- Formulir Promosi -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3]">
        <div class="pb-5 mb-6 border-b border-[#F5E8D3]">
            <h1 class="text-xl sm:text-2xl font-serif font-bold text-[#2B1B10]">Tambah Banner Promosi Baru</h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-1">
                Lengkapi informasi promosi untuk menampilkan penawaran spesial di halaman Beranda.
            </p>
        </div>

        <form action="{{ route('admin.promosi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Promosi -->
            <div class="space-y-1.5">
                <label for="judul" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                    Judul Promosi <span class="text-[#B3281A]">*</span>
                </label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                    placeholder="Contoh: Diskon Jam Sibuk Sore 15% Masak Arang"
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('judul') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                @error('judul')
                    <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rentang Periode -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label for="tanggal_mulai" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                        Tanggal Mulai <span class="text-[#B3281A]">*</span>
                    </label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                        value="{{ old('tanggal_mulai', now()->format('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('tanggal_mulai') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                    @error('tanggal_mulai')
                        <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1.5">
                    <label for="tanggal_selesai" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                        Tanggal Selesai <span class="text-[#B3281A]">*</span>
                    </label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                        value="{{ old('tanggal_selesai', now()->addDays(7)->format('Y-m-d')) }}" required
                        class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('tanggal_selesai') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10 min-h-[44px]">
                    @error('tanggal_selesai')
                        <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi / Syarat Ketentuan -->
            <div class="space-y-1.5">
                <label for="deskripsi" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                    Deskripsi / Keterangan Penawaran (Opsional)
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                    placeholder="Contoh: Dapatkan potongan harga spesial untuk pembelian paket mie goreng dan es teh manis pada pukul 16:00 - 18:00 WIB."
                    class="w-full px-4 py-2.5 rounded-xl border {{ $errors->has('deskripsi') ? 'border-rose-400 bg-rose-50/50' : 'border-[#E5D7C3] bg-white' }} text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:border-[#B3281A] focus:ring-2 focus:ring-[#B3281A]/10">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-[11px] text-rose-600 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Unggah Gambar Banner -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                    Gambar Banner Promosi (Opsional)
                </label>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 p-4 rounded-2xl border border-dashed border-[#E5D7C3] bg-[#FFFBF5]">
                    <!-- Preview Container -->
                    <div id="banner-preview-box" class="w-full sm:w-40 h-24 rounded-xl border border-[#E5D7C3] bg-white overflow-hidden flex items-center justify-center text-xs text-[#A6998F] shrink-0">
                        <span id="banner-placeholder-text">Pratinjau Banner</span>
                        <img id="banner-preview-img" src="" alt="Pratinjau Banner" class="w-full h-full object-cover hidden">
                    </div>

                    <div class="space-y-1 text-xs text-[#6B5B52] flex-1">
                        <input type="file" id="banner" name="banner" accept="image/jpeg,image/png,image/webp"
                            class="block w-full text-xs text-[#2B1B10] file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#B3281A] file:text-white hover:file:bg-[#941F14] file:cursor-pointer cursor-pointer">
                        <p class="text-[11px] text-[#8C7A70]">Format yang didukung: JPG, PNG, atau WebP. Maksimal ukuran berkas: 2 MB.</p>
                        @error('banner')
                            <p class="text-[11px] text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="p-4 rounded-2xl border border-[#F5E8D3] bg-[#FFFBF5] flex items-center justify-between">
                <div>
                    <label for="is_aktif" class="text-xs sm:text-sm font-bold text-[#2B1B10] cursor-pointer">
                        Aktifkan Banner Promosi
                    </label>
                    <p class="text-[11px] text-[#8C7A70]">
                        Jika dicentang, banner akan otomatis tampil di Beranda publik selama tanggal berlaku.
                    </p>
                </div>
                <input type="checkbox" id="is_aktif" name="is_aktif" value="1" {{ old('is_aktif', '1') ? 'checked' : '' }}
                    class="w-5 h-5 text-[#B3281A] rounded border-[#E5D7C3] focus:ring-[#B3281A] cursor-pointer min-h-[44px] min-w-[44px]">
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 border-t border-[#F5E8D3] flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                <a href="{{ route('admin.promosi.index') }}"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-[#E5D7C3] hover:bg-stone-100 text-[#2B1B10] font-semibold text-xs sm:text-sm text-center transition min-h-[44px] flex items-center justify-center">
                    Batal
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-[#B3281A] hover:bg-[#941F14] text-white font-bold text-xs sm:text-sm shadow-sm transition min-h-[44px] flex items-center justify-center cursor-pointer">
                    Simpan Promosi
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Script Pratinjau Foto Banner -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bannerInput = document.getElementById('banner');
        const previewImg = document.getElementById('banner-preview-img');
        const placeholderText = document.getElementById('banner-placeholder-text');

        if (bannerInput) {
            bannerInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImg.src = event.target.result;
                        previewImg.classList.remove('hidden');
                        placeholderText.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImg.src = '';
                    previewImg.classList.add('hidden');
                    placeholderText.classList.remove('hidden');
                }
            });
        }
    });
</script>
@endsection

