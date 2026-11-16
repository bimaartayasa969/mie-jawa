<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\ProfilUsaha;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller untuk katalog sajian hidangan lengkap UMKM Mie Jawa.
 * Menyediakan penyaringan kategori, pencarian hidangan, dan halaman detail sajian.
 */
class KatalogController extends Controller
{
    /**
     * Menampilkan katalog menu dengan fitur penyaringan kategori dan pencarian kata kunci.
     */
    public function index(Request $request): View
    {
        $profil = ProfilUsaha::first();
        $kategori = $request->query('kategori');
        $cari = $request->query('cari');

        $query = Menu::query();

        // Filter berdasarkan kategori yang valid
        if ($kategori && in_array($kategori, Menu::KATEGORI, true)) {
            $query->where('kategori', $kategori);
        }

        // Pencarian berdasarkan nama menu atau deskripsi
        if (! empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama_menu', 'like', "%{$cari}%")
                    ->orWhere('deskripsi', 'like', "%{$cari}%");
            });
        }

        // Menu unggulan diprioritaskan di atas, disusul waktu penambahan terbaru
        $daftarMenu = $query->orderBy('is_unggulan', 'desc')->latest()->get();
        $totalMenu = Menu::count();
        $kategoriList = Menu::KATEGORI;

        return view('publik.katalog', compact('daftarMenu', 'profil', 'kategori', 'cari', 'totalMenu', 'kategoriList'));
    }

    /**
     * Menampilkan halaman detail satu sajian menu lengkap beserta opsi pemesanan WhatsApp.
     */
    public function show(Menu $menu): View
    {
        $profil = ProfilUsaha::first();

        return view('publik.detail-menu', compact('menu', 'profil'));
    }
}
