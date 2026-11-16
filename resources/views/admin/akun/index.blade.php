@extends('layouts.admin')

@section('title', 'Kelola Akun Administrator')
@section('header_title', 'Kelola Akun Administrator')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-block text-[11px] font-bold tracking-wider text-[#B3281A] uppercase bg-[#FEF2F2] px-2.5 py-1 rounded-full border border-[#FCA5A5]">
                    Manajemen Pengguna
                </span>
                <span class="inline-block text-[11px] font-bold tracking-wider text-[#995200] uppercase bg-[#FEF3C7] px-2.5 py-1 rounded-full border border-[#FCD34D]">
                    Akses Eksklusif Owner
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-[#2B1B10]">Kelola Akun Administrator</h1>
            <p class="text-xs sm:text-sm text-[#6B5B52] mt-1 max-w-2xl">
                Atur akun staf operasional warung yang memiliki hak akses untuk mengelola sajian menu, memperbarui ketersediaan bahan, dan foto menu.
            </p>
        </div>

        <div>
            <a href="{{ route('admin.akun.create') }}"
                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#B3281A] hover:bg-[#941F14] text-white font-bold text-xs sm:text-sm shadow-sm transition min-h-[44px]">
                <span>+</span>
                <span>Tambah Akun Admin</span>
            </a>
        </div>
    </div>

    <!-- Tabel Daftar Pengguna -->
    <div class="bg-white rounded-3xl shadow-sm border border-[#F5E8D3] overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-[#F5E8D3] flex items-center justify-between">
            <h2 class="text-sm sm:text-base font-serif font-bold text-[#2B1B10]">
                Daftar Akun Pengelola Warung ({{ $daftarAkun->count() }})
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-[#FFF8EE] text-[#6B5B52] border-b border-[#F5E8D3] text-[11px] font-bold uppercase tracking-wider">
                        <th class="py-3 px-4">Nama &amp; Pengguna</th>
                        <th class="py-3 px-4">Alamat Email</th>
                        <th class="py-3 px-4">Peran (Role)</th>
                        <th class="py-3 px-4">Terdaftar Pada</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#F5E8D3]">
                    @foreach ($daftarAkun as $item)
                        @php
                            $isCurrentUser = $item->id === auth()->id();
                            $isOwnerUser = $item->isOwner();
                        @endphp
                        <tr class="hover:bg-[#FFFBF5] transition {{ $isCurrentUser ? 'bg-amber-50/30' : '' }}">
                            
                            <!-- Nama & Inisial -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-xs {{ $isOwnerUser ? 'bg-[#B3281A] text-white' : 'bg-emerald-700 text-white' }} shrink-0">
                                        {{ $isOwnerUser ? '👑' : '🛡️' }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-[#2B1B10] flex items-center gap-1.5">
                                            <span>{{ $item->nama }}</span>
                                            @if ($isCurrentUser)
                                                <span class="text-[10px] font-semibold text-[#B3281A] bg-[#FEF2F2] px-1.5 py-0.5 rounded border border-[#FCA5A5]">
                                                    Anda
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="py-3.5 px-4 font-mono text-xs text-[#2B1B10]">
                                {{ $item->email }}
                            </td>

                            <!-- Role Badge -->
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if ($isOwnerUser)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#FEF2F2] text-[#B3281A] border border-[#FCA5A5]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#B3281A]"></span>
                                        Pemilik Usaha (Owner)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Administrator (Admin)
                                    </span>
                                @endif
                            </td>

                            <!-- Tanggal Pembuatan -->
                            <td class="py-3.5 px-4 whitespace-nowrap text-xs text-[#6B5B52]">
                                {{ $item->created_at ? $item->created_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                            </td>

                            <!-- Aksi -->
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit -->
                                    <a href="{{ route('admin.akun.edit', $item) }}"
                                        class="p-2 rounded-xl border border-[#E5D7C3] hover:border-[#B3281A] hover:bg-white text-[#2B1B10] hover:text-[#B3281A] transition min-h-[44px] min-w-[44px] flex items-center justify-center"
                                        title="Ubah Akun">
                                        ✏️
                                    </a>

                                    <!-- Hapus (Proteksi: Owner tidak boleh dihapus) -->
                                    @if ($isOwnerUser || $isCurrentUser)
                                        <button type="button" disabled
                                            class="p-2 rounded-xl border border-stone-200 bg-stone-100 text-stone-400 opacity-60 cursor-not-allowed min-h-[44px] min-w-[44px] flex items-center justify-center"
                                            title="Akun Owner tidak dapat dihapus">
                                            🔒
                                        </button>
                                    @else
                                        <form action="{{ route('admin.akun.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun admin \'{{ addslashes($item->nama) }}\' ({{ addslashes($item->email) }})? Akses masuk untuk staf ini akan dicabut permanen.');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 rounded-xl border border-rose-200 hover:border-rose-400 bg-rose-50 hover:bg-rose-100 text-rose-700 transition min-h-[44px] min-w-[44px] flex items-center justify-center cursor-pointer"
                                                title="Hapus Akun Admin">
                                                🗑️
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
