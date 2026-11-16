<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilUsahaRequest;
use App\Models\ProfilUsaha;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Controller untuk mengelola informasi resmi profil usaha UMKM Mie Jawa.
 * Khusus diakses oleh peran Owner untuk mengatur identitas cabang, kontak WhatsApp, koordinat peta, dan logo.
 */
class ProfilUsahaController extends Controller
{
    /**
     * Menampilkan formulir pengaturan profil usaha.
     */
    public function edit(): View
    {
        $profil = ProfilUsaha::firstOrCreate(
            [],
            [
                'nama_usaha' => 'Mie Jawa Masak Anglo Arang',
                'deskripsi' => 'Cita Rasa Gurih Otentik Masak Arang Tradisional Pontianak',
                'alamat' => 'Jl. Sultan Abdurrahman, Mie Goreng Jawa, Pontianak, Kalimantan Barat',
                'latitude' => -0.03550000,
                'longitude' => 109.33100000,
                'no_whatsapp' => '081549077231',
                'instagram' => '@miejawa.official',
                'jam_operasional' => "Senin - Sabtu: 17.00 - 23.00 WIB\nMinggu: Tutup / Libur",
            ]
        );

        return view('admin.profil-usaha.edit', compact('profil'));
    }

    /**
     * Memperbarui data informasi resmi profil usaha.
     */
    public function update(ProfilUsahaRequest $request): RedirectResponse
    {
        $profil = ProfilUsaha::firstOrCreate([]);
        $data = $request->validated();
        $data['updated_by'] = auth()->id();

        // Mengganti logo lama jika pengguna mengunggah berkas baru
        if ($request->hasFile('logo')) {
            if ($profil->logo && Storage::disk('public')->exists($profil->logo)) {
                Storage::disk('public')->delete($profil->logo);
            }

            $data['logo'] = $request->file('logo')->store('logo', 'public');
        }

        $profil->update($data);

        return redirect()
            ->route('admin.profil-usaha.edit')
            ->with('sukses', 'Informasi profil usaha dan kontak berhasil diperbarui.');
    }
}
