@extends('layouts.admin')

@section('title', 'Dasbor Pemilik Usaha')
@section('header_title', 'Ringkasan Bisnis & Finansial')

@section('content')
<div class="space-y-6">
    
    <!-- Banner Sambutan Owner -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3] flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="max-w-3xl">
            <span class="inline-block bg-[#FEF2F2] text-[#B3281A] border border-[#FCA5A5] text-xs font-bold px-3 py-1 rounded-full uppercase mb-2">
                Dasbor {{ (auth()->user() && auth()->user()->isOwner()) ? 'Pemilik Usaha (Owner)' : 'Administrator (Admin)' }}
            </span>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#2B1B10]">
                Ringkasan Bisnis &amp; Finansial Mie Jawa
            </h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-2 leading-relaxed">
                Akses eksklusif Anda untuk memantau performa katalog hidangan, ketersediaan bahan dapur, kampanye promosi, dan rekening pencairan warung.
            </p>
        </div>

        <div class="shrink-0">
            <a href="{{ route('admin.menu.create') }}" class="px-5 py-2.5 bg-[#B3281A] hover:bg-[#8F1F14] text-white rounded-xl text-xs sm:text-sm font-semibold min-h-[44px] flex items-center gap-2 shadow-sm transition">
                <span>+</span>
                <span>Tambah Menu Baru</span>
            </a>
        </div>
    </div>

    <!-- 4 Kartu Metrik Utama Sesuai Kebutuhan User & Mockup 165611 -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Total Menu -->
        <div class="bg-white rounded-2xl p-5 border border-[#F5E8D3] shadow-xs">
            <div class="flex items-center justify-between text-xs text-[#8C7A70] uppercase font-bold tracking-wider">
                <span>Total Sajian Menu</span>
                <span class="text-base">🍜</span>
            </div>
            <div class="text-2xl sm:text-3xl font-bold text-[#2B1B10] mt-2">
                {{ $totalMenu }} <span class="text-xs font-normal text-[#8C7A70]">Sajian Aktif</span>
            </div>
            <div class="text-[11px] text-[#6B5B52] mt-1.5 flex items-center justify-between">
                <span>Siap saji: <strong class="text-emerald-700">{{ $menuTersedia }}</strong></span>
                <a href="{{ route('admin.menu.index') }}" class="text-[#B3281A] font-bold hover:underline">Kelola →</a>
            </div>
        </div>

        <!-- 2. Menu Habis (Perlu Restok Bahan) -->
        <div class="bg-white rounded-2xl p-5 border border-[#F5E8D3] shadow-xs">
            <div class="flex items-center justify-between text-xs text-[#8C7A70] uppercase font-bold tracking-wider">
                <span>Menu Habis</span>
                <span class="text-base text-red-500">⚠️</span>
            </div>
            <div class="text-2xl sm:text-3xl font-bold {{ $menuHabis > 0 ? 'text-[#B3281A]' : 'text-emerald-700' }} mt-2">
                {{ $menuHabis }} <span class="text-xs font-normal text-[#8C7A70]">Perlu Bahan</span>
            </div>
            <div class="text-[11px] text-[#6B5B52] mt-1.5">
                {{ $menuHabis > 0 ? 'Bahan baku menu tertentu sedang habis' : 'Semua hidangan siap dipesan' }}
            </div>
        </div>

        <!-- 3. Promosi Aktif -->
        <div class="bg-white rounded-2xl p-5 border border-[#F5E8D3] shadow-xs">
            <div class="flex items-center justify-between text-xs text-[#8C7A70] uppercase font-bold tracking-wider">
                <span>Promosi Aktif</span>
                <span class="text-base text-amber-500">🏷️</span>
            </div>
            <div class="text-2xl sm:text-3xl font-bold text-[#2B1B10] mt-2">
                {{ $promosiAktif }} <span class="text-xs font-normal text-[#8C7A70]">Tayang</span>
            </div>
            <div class="text-[11px] text-[#6B5B52] mt-1.5 flex items-center justify-between">
                <span>Tampil di beranda publik</span>
                <a href="{{ route('admin.promosi.index') }}" class="text-[#B3281A] font-bold hover:underline">Atur →</a>
            </div>
        </div>

        <!-- 4. Rekening Pencairan & Info Toko -->
        <div class="bg-white rounded-2xl p-5 border border-[#F5E8D3] shadow-xs">
            <div class="flex items-center justify-between text-xs text-[#8C7A70] uppercase font-bold tracking-wider">
                <span>Rekening Pencairan</span>
                <span class="text-base text-indigo-500">💳</span>
            </div>
            <div class="text-sm font-bold text-[#2B1B10] mt-2 truncate">
                BCA (Bank Central Asia)
            </div>
            <div class="text-[11px] text-[#8C7A70] mt-1 truncate">
                8910-2341-99 a/n {{ auth()->user()->nama }}
            </div>
            <div class="text-[10px] text-emerald-700 font-semibold mt-1">
                ● Wewenang Pemilik Usaha
            </div>
        </div>

    </div>

    <!-- Tautan Menu Cepat Khusus Pemilik Usaha -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <a href="{{ route('admin.promosi.index') }}" class="p-5 bg-white rounded-2xl border border-[#F5E8D3] hover:border-[#B3281A] shadow-xs transition group">
            <div class="w-10 h-10 rounded-xl bg-[#FEF2F2] text-[#B3281A] flex items-center justify-center text-lg mb-3 group-hover:scale-105 transition">
                🏷️
            </div>
            <h3 class="font-bold text-sm text-[#2B1B10]">Strategi Promosi Pelanggan</h3>
            <p class="text-xs text-[#6B5B52] mt-1">Pantau &amp; atur pesan diskon yang tampil di halaman beranda publik.</p>
        </a>

        <a href="{{ route('admin.profil-usaha.edit') }}" class="p-5 bg-white rounded-2xl border border-[#F5E8D3] hover:border-[#B3281A] shadow-xs transition group">
            <div class="w-10 h-10 rounded-xl bg-[#FEF2F2] text-[#B3281A] flex items-center justify-center text-lg mb-3 group-hover:scale-105 transition">
                🏪
            </div>
            <h3 class="font-bold text-sm text-[#2B1B10]">Profil Bisnis &amp; Rekening</h3>
            <p class="text-xs text-[#6B5B52] mt-1">Perbarui nomor WhatsApp, alamat Pontianak, dan jam operasional.</p>
        </a>

        <a href="{{ route('admin.akun.index') }}" class="p-5 bg-white rounded-2xl border border-[#F5E8D3] hover:border-[#B3281A] shadow-xs transition group">
            <div class="w-10 h-10 rounded-xl bg-[#FEF2F2] text-[#B3281A] flex items-center justify-center text-lg mb-3 group-hover:scale-105 transition">
                👥
            </div>
            <h3 class="font-bold text-sm text-[#2B1B10]">Kelola Akun Administrator</h3>
            <p class="text-xs text-[#6B5B52] mt-1">Tambah staf pengelola dapur, ubah kata sandi, dan atur otorisasi.</p>
        </a>

    </div>

    <!-- Tabel Monitoring Menu Terdaftar -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#F5E8D3]">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-serif font-bold text-lg text-[#2B1B10]">Monitoring Sajian Menu</h3>
                <p class="text-xs text-[#8C7A70]">Pantau harga jual dan ketersediaan menu yang sedang dipublikasikan.</p>
            </div>
            <a href="{{ route('admin.menu.index') }}" class="px-3.5 py-2 bg-[#FFF8EE] hover:bg-[#F5E8D3] border border-[#E5D7C3] text-[#2B1B10] rounded-xl text-xs font-semibold min-h-[36px] flex items-center transition">
                Buka Semua Menu ({{ $totalMenu }}) →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-[#F5E8D3] text-[#8C7A70] uppercase text-[11px] font-bold tracking-wider">
                        <th class="py-2.5 px-3">Nama Menu</th>
                        <th class="py-2.5 px-3">Kategori</th>
                        <th class="py-2.5 px-3">Harga</th>
                        <th class="py-2.5 px-3">Status</th>
                        <th class="py-2.5 px-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F7EFE2]">
                    @forelse ($ringkasanMenu as $item)
                        <tr class="hover:bg-[#FFFDF9]">
                            <td class="py-3 px-3 font-semibold text-[#2B1B10]">{{ $item->nama_menu }}</td>
                            <td class="py-3 px-3 text-[#6B5B52]">{{ $item->kategori }}</td>
                            <td class="py-3 px-3 font-bold text-[#B3281A]">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->status === 'tersedia' ? 'bg-emerald-50 text-emerald-800' : 'bg-red-50 text-[#B3281A]' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <a href="{{ route('admin.menu.edit', $item) }}" class="text-[#B3281A] hover:underline font-semibold text-xs">
                                    Edit →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-[#8C7A70]">Belum ada menu terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
