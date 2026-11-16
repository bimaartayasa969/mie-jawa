<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\ProfilUsaha;
use App\Models\Promosi;
use Illuminate\View\View;

/**
 * Controller untuk halaman beranda publik UMKM Mie Jawa.
 * Mengambil data profil warung, promosi aktif yang berlaku hari ini, dan daftar menu unggulan.
 */
class BerandaController extends Controller
{
    /**
     * Menampilkan halaman beranda publik dengan data dinamis dari basis data.
     */
    public function index(): View
    {
        $profil = ProfilUsaha::first();

        // Mengambil menu unggulan yang berstatus tersedia (maksimal 4 item sesuai mockup)
        $menuUnggulan = Menu::where('is_unggulan', true)
            ->where('status', 'tersedia')
            ->take(4)
            ->get();

        // Jika menu unggulan kurang dari 4, lengkapi dengan menu tersedia lainnya
        if ($menuUnggulan->count() < 4) {
            $tambahan = Menu::where('status', 'tersedia')
                ->whereNotIn('id', $menuUnggulan->pluck('id'))
                ->take(4 - $menuUnggulan->count())
                ->get();
            $menuUnggulan = $menuUnggulan->merge($tambahan);
        }

        // Mengambil promosi aktif yang periodenya mencakup hari ini
        $hariIni = now()->toDateString();
        $promosiAktif = Promosi::where('is_aktif', true)
            ->whereDate('tanggal_mulai', '<=', $hariIni)
            ->whereDate('tanggal_selesai', '>=', $hariIni)
            ->latest()
            ->first();

        return view('publik.beranda', compact('profil', 'menuUnggulan', 'promosiAktif'));
    }
}
