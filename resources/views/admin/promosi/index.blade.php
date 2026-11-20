@extends('layouts.admin')

@section('title', 'Kelola Banner Promosi')
@section('header_title', 'Kelola Banner Promosi')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-[#F5E8D3] flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-block text-xs sm:text-sm font-bold tracking-wider text-[#B3281A] uppercase bg-[#FEF2F2] px-3 py-1 rounded-full border border-[#FCA5A5]">
                    Pemasaran &amp; Promosi
                </span>
                <span class="inline-block text-xs sm:text-sm font-bold tracking-wider text-[#995200] uppercase bg-[#FEF3C7] px-3 py-1 rounded-full border border-[#FCD34D]">
                    Akses Pengelola
                </span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-serif font-bold text-[#2B1B10]">Kelola Banner Promosi</h1>
            <p class="text-sm sm:text-base text-[#6B5B52] mt-1 max-w-2xl">
                Atur pengumuman promosi, diskon hemat, atau penawaran khusus yang tampil di bagian paling atas halaman Beranda publik.
            </p>
        </div>

        <div>
            <a href="{{ route('admin.promosi.create') }}"
                class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-[#B3281A] hover:bg-[#941F14] text-white font-bold text-sm sm:text-base shadow-sm transition min-h-[48px]">
                <span class="text-lg">+</span>
                <span>Tambah Banner Promosi</span>
            </a>
        </div>
    </div>

    @php
        $today = now()->startOfDay();
        $promosiAktifHariIni = $daftarPromosi->first(function ($item) use ($today) {
            return $item->is_aktif && $today->between($item->tanggal_mulai, $item->tanggal_selesai);
        });
    @endphp

    <!-- Pratinjau Tampilan Banner Beranda -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-[#F5E8D3] space-y-3">
        <div class="flex items-center justify-between pb-3 border-b border-[#F5E8D3]">
            <h2 class="text-xs sm:text-sm font-bold text-[#2B1B10] uppercase tracking-wider flex items-center gap-2">
                <span>👁️</span> Pratinjau Tampilan Banner Beranda Publik
            </h2>
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $promosiAktifHariIni ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-stone-100 text-stone-600 border border-stone-200' }}">
                {{ $promosiAktifHariIni ? 'Sedang Tayang di Beranda' : 'Tidak Ada Banner Tayang' }}
            </span>
        </div>

        @if ($promosiAktifHariIni)
            <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-[#B3281A] to-[#8C1D12] text-white shadow-md relative overflow-hidden">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                    <div class="space-y-1">
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#F2B84B] text-[#2B1B10] text-[11px] font-bold">
                            <span>🔥</span> PROMOSI SPESIAL
                        </div>
                        <h3 class="text-base sm:text-lg font-serif font-bold text-white">
                            {{ $promosiAktifHariIni->judul }}
                        </h3>
                        @if ($promosiAktifHariIni->deskripsi)
                            <p class="text-xs sm:text-sm text-[#FFE8D6] line-clamp-2">
                                {{ $promosiAktifHariIni->deskripsi }}
                            </p>
                        @endif
                        <p class="text-[11px] text-[#FCD34D]">
                            Periode: {{ $promosiAktifHariIni->tanggal_mulai->translatedFormat('d M Y') }} s.d. {{ $promosiAktifHariIni->tanggal_selesai->translatedFormat('d M Y') }}
                        </p>
                    </div>

                    @if ($promosiAktifHariIni->banner)
                        <div class="w-full sm:w-44 h-24 rounded-xl overflow-hidden bg-black/20 shrink-0 border border-white/20">
                            <img src="{{ asset('storage/' . $promosiAktifHariIni->banner) }}" alt="{{ $promosiAktifHariIni->judul }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="p-6 rounded-2xl border-2 border-dashed border-[#E5D7C3] text-center text-xs text-[#8C7A70] bg-[#FFFBF5]">
                <p>Saat ini tidak ada banner promosi yang aktif dan berada dalam rentang tanggal hari ini.</p>
                <p class="mt-1 text-[11px] text-[#A6998F]">Aktifkan status promosi atau tambahkan promosi baru di bawah ini agar banner tampil di beranda.</p>
            </div>
        @endif
    </div>

    <!-- Tabel / Daftar Banner Promosi -->
    <div class="bg-white rounded-3xl shadow-sm border border-[#F5E8D3] overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-[#F5E8D3] flex items-center justify-between">
            <h2 class="text-sm sm:text-base font-serif font-bold text-[#2B1B10]">
                Daftar Riwayat &amp; Kampanye Promosi ({{ $daftarPromosi->count() }})
            </h2>
        </div>

        @if ($daftarPromosi->isEmpty())
            <div class="p-12 text-center space-y-3">
                <div class="w-16 h-16 mx-auto rounded-full bg-[#FFF8EE] text-[#B3281A] flex items-center justify-center text-2xl border border-[#F5E8D3]">
                    🏷️
                </div>
                <h3 class="text-base font-serif font-bold text-[#2B1B10]">Belum Ada Promosi</h3>
                <p class="text-xs sm:text-sm text-[#8C7A70] max-w-md mx-auto">
                    Buat promosi pertama untuk menarik lebih banyak pelanggan ke warung Mie Jawa Masak Anglo Arang.
                </p>
                <a href="{{ route('admin.promosi.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#B3281A] text-white text-xs font-bold hover:bg-[#941F14] transition min-h-[44px]">
                    + Buat Promosi Sekarang
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm sm:text-base">
                    <thead>
                        <tr class="bg-[#FFF8EE] text-[#6B5B52] border-b border-[#F5E8D3] text-xs sm:text-sm font-bold uppercase tracking-wider">
                            <th class="py-4 px-4">Banner</th>
                            <th class="py-4 px-4">Judul &amp; Keterangan</th>
                            <th class="py-4 px-4">Periode Berlaku</th>
                            <th class="py-4 px-4">Status</th>
                            <th class="py-4 px-4">Dibuat Oleh</th>
                            <th class="py-4 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F5E8D3]">
                        @foreach ($daftarPromosi as $item)
                            @php
                                $isCurrentlyValid = $item->is_aktif && $today->between($item->tanggal_mulai, $item->tanggal_selesai);
                                $isExpired = $today->gt($item->tanggal_selesai);
                                $isUpcoming = $today->lt($item->tanggal_mulai);
                            @endphp
                            <tr class="hover:bg-[#FFFBF5] transition">
                                <!-- Banner Preview -->
                                <td class="py-4 px-4">
                                    @if ($item->banner)
                                        <div class="w-20 h-14 rounded-xl overflow-hidden bg-[#FFF8EE] border border-[#E5D7C3] shrink-0">
                                            <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-20 h-14 rounded-xl bg-[#FFF8EE] border border-dashed border-[#E5D7C3] flex items-center justify-center text-xs text-[#A6998F] shrink-0">
                                            Tanpa Foto
                                        </div>
                                    @endif
                                </td>

                                <!-- Judul & Deskripsi -->
                                <td class="py-4 px-4 min-w-[220px]">
                                    <div class="font-bold text-[#2B1B10] text-base sm:text-lg">
                                        {{ $item->judul }}
                                    </div>
                                    @if ($item->deskripsi)
                                        <div class="text-xs sm:text-sm text-[#8C7A70] line-clamp-2 mt-0.5">
                                            {{ $item->deskripsi }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Periode -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <div class="text-xs sm:text-sm font-semibold text-[#2B1B10]">
                                        {{ $item->tanggal_mulai->translatedFormat('d M Y') }}
                                    </div>
                                    <div class="text-xs text-[#8C7A70]">
                                        s.d. {{ $item->tanggal_selesai->translatedFormat('d M Y') }}
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if (!$item->is_aktif)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs sm:text-sm font-bold bg-stone-100 text-stone-600 border border-stone-200">
                                            <span class="w-2 h-2 rounded-full bg-stone-400"></span>
                                            Nonaktif
                                        </span>
                                    @elseif ($isCurrentlyValid)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs sm:text-sm font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                            Tayang Aktif
                                        </span>
                                    @elseif ($isExpired)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs sm:text-sm font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                            Kedaluwarsa
                                        </span>
                                    @elseif ($isUpcoming)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs sm:text-sm font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                            Terjadwal
                                        </span>
                                    @endif
                                </td>

                                <!-- Dibuat Oleh -->
                                <td class="py-4 px-4 whitespace-nowrap text-xs sm:text-sm text-[#6B5B52]">
                                    {{ $item->user->nama ?? '-' }}
                                </td>

                                <!-- Aksi -->
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit -->
                                        <a href="{{ route('admin.promosi.edit', $item) }}"
                                            class="w-11 h-11 rounded-xl border border-[#E5D7C3] hover:border-[#B3281A] hover:bg-white text-[#2B1B10] hover:text-[#B3281A] transition min-h-[44px] min-w-[44px] flex items-center justify-center text-base"
                                            title="Ubah Promosi">
                                            ✏️
                                        </a>

                                        <!-- Hapus dengan Dialog Konfirmasi -->
                                        <form action="{{ route('admin.promosi.destroy', $item) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus promosi \'{{ addslashes($item->judul) }}\'? Tindakan ini tidak dapat dibatalkan.');"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-11 h-11 rounded-xl border border-rose-200 hover:border-rose-400 bg-rose-50 hover:bg-rose-100 text-rose-700 transition min-h-[44px] min-w-[44px] flex items-center justify-center cursor-pointer text-base"
                                                title="Hapus Promosi">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
