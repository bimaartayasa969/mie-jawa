<?php

namespace App\Http\Controllers;

use App\Models\ProfilUsaha;
use Illuminate\View\View;

/**
 * Controller untuk halaman kontak dan saluran komunikasi UMKM Mie Jawa.
 * Menyediakan tautan langsung WhatsApp dan formulir pesan otomatis ke chat pemilik usaha.
 */
class KontakController extends Controller
{
    /**
     * Menampilkan informasi saluran kontak dan formulir pemesanan cepat via WhatsApp.
     */
    public function index(): View
    {
        $profil = ProfilUsaha::first();

        return view('publik.kontak', compact('profil'));
    }
}
