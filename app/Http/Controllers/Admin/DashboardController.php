<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\ProfilUsaha;
use App\Models\Promosi;
use Illuminate\View\View;

/**
 * Controller untuk dasbor eksekutif pemilik usaha (Owner).
 * Menyajikan statistik total menu, menu habis, promosi aktif, dan data profil usaha.
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dasbor utama Owner dengan metrik bisnis terkini dari basis data.
     */
    public function index(): View
    {
        $totalMenu = Menu::count();
        $menuTersedia = Menu::where('status', 'tersedia')->count();
        $menuHabis = Menu::where('status', 'habis')->count();

        // Menghitung promosi aktif yang periodenya berlaku hari ini
        $hariIni = now()->toDateString();
        $promosiAktif = Promosi::where('is_aktif', true)
            ->whereDate('tanggal_mulai', '<=', $hariIni)
            ->whereDate('tanggal_selesai', '>=', $hariIni)
            ->count();

        // 5 hidangan menu untuk tabel monitoring ketersediaan dapur
        $ringkasanMenu = Menu::orderBy('is_unggulan', 'desc')->latest()->take(5)->get();
        $profil = ProfilUsaha::first();

        return view('admin.dashboard', compact(
            'totalMenu',
            'menuTersedia',
            'menuHabis',
            'promosiAktif',
            'ringkasanMenu',
            'profil'
        ));
    }
}
