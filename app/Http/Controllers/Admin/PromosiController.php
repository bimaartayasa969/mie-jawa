<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromosiRequest;
use App\Models\Promosi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Controller untuk mengelola kampanye banner promosi UMKM Mie Jawa.
 * Khusus diakses oleh peran Owner untuk kebijakan penawaran, diskon, dan banner di halaman beranda.
 */
class PromosiController extends Controller
{
    /**
     * Menampilkan daftar seluruh promosi yang terdaftar.
     */
    public function index(): View
    {
        $daftarPromosi = Promosi::with('user')->latest()->get();

        return view('admin.promosi.index', compact('daftarPromosi'));
    }

    /**
     * Menampilkan formulir tambah banner promosi baru.
     */
    public function create(): View
    {
        return view('admin.promosi.create');
    }

    /**
     * Menyimpan data promosi baru ke basis data.
     */
    public function store(PromosiRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();
        $data['is_aktif'] = $request->boolean('is_aktif');

        // Menangani unggahan banner promosi jika ada
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('promosi', 'public');
        }

        Promosi::create($data);

        return redirect()
            ->route('admin.promosi.index')
            ->with('sukses', 'Banner promosi berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir ubah data promosi.
     */
    public function edit(Promosi $promosi): View
    {
        return view('admin.promosi.edit', compact('promosi'));
    }

    /**
     * Memperbarui data promosi yang sudah ada.
     */
    public function update(PromosiRequest $request, Promosi $promosi): RedirectResponse
    {
        $data = $request->validated();
        $data['is_aktif'] = $request->boolean('is_aktif');

        // Mengganti banner lama jika pengguna mengunggah berkas baru
        if ($request->hasFile('banner')) {
            if ($promosi->banner && Storage::disk('public')->exists($promosi->banner)) {
                Storage::disk('public')->delete($promosi->banner);
            }

            $data['banner'] = $request->file('banner')->store('promosi', 'public');
        }

        $promosi->update($data);

        return redirect()
            ->route('admin.promosi.index')
            ->with('sukses', 'Data promosi berhasil diperbarui.');
    }

    /**
     * Menghapus promosi beserta berkas bannernya dari media penyimpanan.
     */
    public function destroy(Promosi $promosi): RedirectResponse
    {
        if ($promosi->banner && Storage::disk('public')->exists($promosi->banner)) {
            Storage::disk('public')->delete($promosi->banner);
        }

        $promosi->delete();

        return redirect()
            ->route('admin.promosi.index')
            ->with('sukses', 'Promosi berhasil dihapus.');
    }
}
