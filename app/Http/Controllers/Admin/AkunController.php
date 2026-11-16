<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AkunRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Controller untuk mengelola akun staf administrator warung UMKM Mie Jawa.
 * Khusus diakses oleh peran Owner untuk menambah, mengedit, dan menghapus akun staf.
 * Memuat aturan ketat: Owner tidak boleh menghapus akunnya sendiri.
 */
class AkunController extends Controller
{
    /**
     * Menampilkan daftar seluruh akun pengelola (Owner dan Admin).
     */
    public function index(): View
    {
        $daftarAkun = User::latest()->get();

        return view('admin.akun.index', compact('daftarAkun'));
    }

    /**
     * Menampilkan formulir pendaftaran akun administrator baru.
     */
    public function create(): View
    {
        return view('admin.akun.create');
    }

    /**
     * Menyimpan data akun administrator baru ke basis data dengan kata sandi ter-hash.
     */
    public function store(AkunRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['role'] = $data['role'] ?? 'admin';

        User::create($data);

        return redirect()
            ->route('admin.akun.index')
            ->with('sukses', 'Akun administrator baru berhasil didaftarkan.');
    }

    /**
     * Menampilkan formulir pengubahan data akun.
     */
    public function edit(User $akun): View
    {
        return view('admin.akun.edit', compact('akun'));
    }

    /**
     * Memperbarui informasi akun, termasuk pergantian kata sandi jika diisi.
     */
    public function update(AkunRequest $request, User $akun): RedirectResponse
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        // Mencegah perubahan peran yang tidak sengaja pada akun owner utama
        if ($akun->isOwner() && empty($data['role'])) {
            unset($data['role']);
        }

        $akun->update($data);

        return redirect()
            ->route('admin.akun.index')
            ->with('sukses', 'Data akun pengelola berhasil diperbarui.');
    }

    /**
     * Menghapus akun pengelola.
     * Aturan bisnis: Owner tidak boleh menghapus akunnya sendiri atau akun dengan peran Owner.
     */
    public function destroy(User $akun): RedirectResponse
    {
        if ($akun->id === auth()->id() || $akun->isOwner()) {
            return redirect()
                ->route('admin.akun.index')
                ->with('gagal', 'Akun Pemilik Usaha (Owner) tidak dapat dihapus demi keamanan operasional sistem.');
        }

        $akun->delete();

        return redirect()
            ->route('admin.akun.index')
            ->with('sukses', 'Akun administrator berhasil dihapus dari sistem.');
    }
}
