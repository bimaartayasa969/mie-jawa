@extends('layouts.admin')

@section('title', 'Ubah Menu: ' . $menu->nama_menu)
@section('header_title', 'Katalog Usaha - Edit Menu')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Header Formulir Edit Menu -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3] flex items-center justify-between">
        <div>
            <a href="{{ route('admin.menu.index') }}" class="inline-flex items-center gap-1.5 text-xs text-[#8C7A70] hover:text-[#B3281A] transition mb-2 font-semibold">
                ← Kembali ke Daftar Menu
            </a>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#2B1B10]">
                Ubah Hidangan Menu
            </h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-1">
                Perbarui harga, status ketersediaan, deskripsi, atau ganti foto sajian <strong class="text-[#2B1B10]">{{ $menu->nama_menu }}</strong>.
            </p>
        </div>
    </div>

    <!-- Formulir Edit Menu -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3]">
        <form action="{{ route('admin.menu.update', $menu) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Nama Menu -->
            <div>
                <label for="nama_menu" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider mb-2">
                    Nama Menu <span class="text-[#B3281A]">*</span>
                </label>
                <input type="text" id="nama_menu" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" required
                    class="w-full px-4 py-3 bg-[#FFF8EE]/50 border border-[#E5D7C3] rounded-2xl text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:ring-2 focus:ring-[#B3281A] focus:bg-white min-h-[44px]">
                @error('nama_menu')
                    <p class="text-[11px] text-[#B3281A] font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Harga & Kategori (Grid 2 Kolom) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider mb-2">
                        Harga (Rupiah) <span class="text-[#B3281A]">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-xs font-bold text-[#8C7A70]">
                            Rp
                        </span>
                        <input type="number" id="harga" name="harga" value="{{ old('harga', $menu->harga) }}" required min="0" step="500"
                            class="w-full pl-11 pr-4 py-3 bg-[#FFF8EE]/50 border border-[#E5D7C3] rounded-2xl text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:ring-2 focus:ring-[#B3281A] focus:bg-white min-h-[44px]">
                    </div>
                    @error('harga')
                        <p class="text-[11px] text-[#B3281A] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dropdown Kategori -->
                <div>
                    <label for="kategori" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider mb-2">
                        Kategori Menu <span class="text-[#B3281A]">*</span>
                    </label>
                    <select id="kategori" name="kategori" required
                        class="w-full px-4 py-3 bg-[#FFF8EE]/50 border border-[#E5D7C3] rounded-2xl text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:ring-2 focus:ring-[#B3281A] focus:bg-white min-h-[44px] cursor-pointer">
                        @foreach ($kategoriList as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $menu->kategori) === $kat ? 'selected' : '' }}>
                                {{ $kat }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="text-[11px] text-[#B3281A] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 3. Deskripsi Menu -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider mb-2">
                    Deskripsi Menu
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                    class="w-full px-4 py-3 bg-[#FFF8EE]/50 border border-[#E5D7C3] rounded-2xl text-xs sm:text-sm text-[#2B1B10] focus:outline-none focus:ring-2 focus:ring-[#B3281A] focus:bg-white resize-none">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-[11px] text-[#B3281A] font-semibold mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 4. Ganti Foto Kuliner dengan Pratinjau -->
            <div class="p-5 rounded-2xl border border-[#F5E8D3] bg-[#FFF8EE]/40 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider">
                        Ganti Foto Kuliner
                    </label>
                    <p class="text-[11px] text-[#8C7A70] mt-0.5">
                        Biarkan kosong jika tidak ingin mengubah foto. Format: JPG, PNG, WebP (maks. 2 MB).
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-5">
                    <!-- Foto Saat Ini / Pratinjau Baru -->
                    <div class="w-32 h-32 rounded-2xl bg-white border-2 border-dashed border-[#E5D7C3] overflow-hidden flex items-center justify-center shrink-0 relative shadow-xs">
                        <img id="image-preview" 
                             src="{{ $menu->foto && (file_exists(public_path('storage/' . $menu->foto)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->foto)) ? asset('storage/' . $menu->foto) : '#' }}" 
                             alt="Foto hidangan {{ $menu->nama_menu }}" 
                             class="w-full h-full object-cover {{ $menu->foto && (file_exists(public_path('storage/' . $menu->foto)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->foto)) ? '' : 'hidden' }}">
                        
                        <div id="image-preview-placeholder" class="text-center p-2 text-[#8C7A70] {{ ($menu->foto && (file_exists(public_path('storage/' . $menu->foto)) || \Illuminate\Support\Facades\Storage::disk('public')->exists($menu->foto))) ? 'hidden' : '' }}">
                            <span class="text-2xl block mb-1">📷</span>
                            <span class="text-[10px] font-semibold">Belum ada foto</span>
                        </div>
                    </div>

                    <!-- Input Berkas Pengganti -->
                    <div class="flex-1 space-y-2 w-full">
                        <input type="file" id="foto" name="foto" accept="image/jpeg,image/png,image/webp"
                            onchange="previewUploadedImage(event)"
                            class="block w-full text-xs text-[#6B5B52] file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#B3281A] file:text-white hover:file:bg-[#8F1F14] file:cursor-pointer cursor-pointer min-h-[44px]">
                        @if ($menu->foto)
                            <p class="text-[11px] text-emerald-700 font-semibold">
                                ✓ Saat ini menggunakan foto: <code class="text-[10px] bg-emerald-50 px-1 py-0.5 rounded">{{ basename($menu->foto) }}</code>
                            </p>
                        @endif
                        @error('foto')
                            <p class="text-[11px] text-[#B3281A] font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 5. Status Ketersediaan Bahan Baku & Menu Unggulan -->
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-[#2B1B10] uppercase tracking-wider mb-2">
                        Status Ketersediaan Bahan Baku <span class="text-[#B3281A]">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Pilihan 1: Tersedia -->
                        <label id="label-status-tersedia" 
                            class="p-4 rounded-2xl border-2 cursor-pointer transition min-h-[44px] flex items-center justify-between {{ old('status', $menu->status) === 'tersedia' ? 'border-emerald-600 bg-emerald-50/50' : 'border-[#E5D7C3] bg-white hover:border-emerald-300' }}">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="status" value="tersedia" 
                                    {{ old('status', $menu->status) === 'tersedia' ? 'checked' : '' }}
                                    onchange="updateStatusCardStyle('tersedia')"
                                    class="w-5 h-5 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                                <div>
                                    <div class="text-xs font-bold text-[#2B1B10] flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                        <span>Tersedia</span>
                                    </div>
                                    <div class="text-[11px] text-[#6B5B52]">Bahan baku siap &amp; dapat dipesan</div>
                                </div>
                            </div>
                            <span class="text-xs text-emerald-700 font-bold">✓</span>
                        </label>

                        <!-- Pilihan 2: Habis / Tidak Tersedia -->
                        <label id="label-status-habis" 
                            class="p-4 rounded-2xl border-2 cursor-pointer transition min-h-[44px] flex items-center justify-between {{ old('status', $menu->status) === 'habis' ? 'border-[#B3281A] bg-rose-50/50' : 'border-[#E5D7C3] bg-white hover:border-rose-300' }}">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="status" value="habis" 
                                    {{ old('status', $menu->status) === 'habis' ? 'checked' : '' }}
                                    onchange="updateStatusCardStyle('habis')"
                                    class="w-5 h-5 text-[#B3281A] border-gray-300 focus:ring-[#B3281A]">
                                <div>
                                    <div class="text-xs font-bold text-[#B3281A] flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-[#B3281A] inline-block"></span>
                                        <span>Habis / Tidak Tersedia</span>
                                    </div>
                                    <div class="text-[11px] text-[#6B5B52]">Bahan habis, tampil dengan tanda 'Habis'</div>
                                </div>
                            </div>
                            <span class="text-xs text-[#B3281A] font-bold">✕</span>
                        </label>
                    </div>
                    @error('status')
                        <p class="text-[11px] text-[#B3281A] font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Menu Unggulan -->
                <label class="p-4 rounded-2xl border border-[#F5E8D3] bg-white hover:bg-[#FFFDF9] flex items-start gap-3 cursor-pointer min-h-[44px] transition shadow-xs">
                    <input type="checkbox" name="is_unggulan" value="1" 
                        {{ old('is_unggulan', $menu->is_unggulan) ? 'checked' : '' }}
                        class="w-5 h-5 text-[#B3281A] border-[#E5D7C3] rounded focus:ring-[#B3281A] mt-0.5">
                    <div>
                        <div class="text-xs font-bold text-[#2B1B10]">Jadikan Menu Unggulan</div>
                        <div class="text-[11px] text-[#8C7A70]">Tampilkan di pilihan menu unggulan beranda website</div>
                    </div>
                </label>
            </div>

            <!-- Tombol Aksi Batal & Simpan Perubahan -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#F7EFE2]">
                <a href="{{ route('admin.menu.index') }}" 
                    class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-[#2B1B10] font-semibold rounded-2xl text-xs sm:text-sm min-h-[44px] flex items-center transition cursor-pointer">
                    Batal
                </a>

                <button type="submit" 
                    class="px-7 py-3 bg-[#B3281A] hover:bg-[#8F1F14] text-white font-semibold rounded-2xl text-xs sm:text-sm min-h-[44px] flex items-center gap-2 transition shadow-md cursor-pointer">
                    <span>Perbarui Menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    function updateStatusCardStyle(status) {
        const labelTersedia = document.getElementById('label-status-tersedia');
        const labelHabis = document.getElementById('label-status-habis');
        if (status === 'tersedia') {
            labelTersedia.className = 'p-4 rounded-2xl border-2 cursor-pointer transition min-h-[44px] flex items-center justify-between border-emerald-600 bg-emerald-50/50';
            labelHabis.className = 'p-4 rounded-2xl border-2 cursor-pointer transition min-h-[44px] flex items-center justify-between border-[#E5D7C3] bg-white hover:border-rose-300';
        } else {
            labelTersedia.className = 'p-4 rounded-2xl border-2 cursor-pointer transition min-h-[44px] flex items-center justify-between border-[#E5D7C3] bg-white hover:border-emerald-300';
            labelHabis.className = 'p-4 rounded-2xl border-2 cursor-pointer transition min-h-[44px] flex items-center justify-between border-[#B3281A] bg-rose-50/50';
        }
    }

    function previewUploadedImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.getElementById('image-preview');
                const placeholder = document.getElementById('image-preview-placeholder');
                img.src = e.target.result;
                img.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection

