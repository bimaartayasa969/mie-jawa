<?php

namespace App\Http\Controllers;

use App\Models\ProfilUsaha;
use Illuminate\View\View;

/**
 * Controller untuk halaman lokasi dan jam operasional warung UMKM Mie Jawa.
 * Menyediakan titik koordinat peta Google Maps embed, alamat fisik, dan panduan kunjungan.
 */
class LokasiController extends Controller
{
    /**
     * Menampilkan halaman lokasi fisik warung dan jadwal jam operasional dari basis data.
     */
    public function index(): View
    {
        $profil = ProfilUsaha::first();

        return view('publik.lokasi', compact('profil'));
    }
}
