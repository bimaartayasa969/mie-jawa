<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Controller untuk mengelola data katalog sajian menu UMKM Mie Jawa.
 * Menyediakan operasi CRUD penuh, penanganan unggahan berkas foto, dan penghapusan berkas terkait.
 */
class MenuController extends Controller
{
    /**
     * Menampilkan daftar menu hidangan dengan dukungan filter kategori, pencarian, dan pilihan tampilan.
     */
    public function index(Request $request): View
    {
        $kategori = $request->query('kategori');
        $cari = $request->query('cari');
        $tampilan = $request->query('tampilan', 'tabel'); // Default tampilan tabel kelola

        $query = Menu::query();

        if ($kategori && in_array($kategori, Menu::KATEGORI, true)) {
            $query->where('kategori', $kategori);
        }

        if (! empty($cari)) {
            $query->where(function ($q) use ($cari) {
                $q->where('nama_menu', 'like', "%{$cari}%")
                    ->orWhere('deskripsi', 'like', "%{$cari}%");
            });
        }

        $daftarMenu = $query->orderBy('is_unggulan', 'desc')->latest()->get();
        $kategoriList = Menu::KATEGORI;

        return view('admin.menu.index', compact('daftarMenu', 'kategoriList', 'kategori', 'cari', 'tampilan'));
    }

    /**
     * Menampilkan formulir penambahan hidangan menu baru.
     */
    public function create(): View
    {
        $kategoriList = Menu::KATEGORI;

        return view('admin.menu.create', compact('kategoriList'));
    }

    /**
     * Menyimpan data hidangan menu baru ke dalam basis data.
     */
    public function store(MenuRequest $request): RedirectResponse
    {
        $data = $request->validated();
        
        // Menetapkan pengguna yang menambahkan data menu
        $data['created_by'] = auth()->id();

        // Penanganan berkas foto jika diunggah
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Menghasilkan nama berkas acak yang unik dan aman
            $namaBerkasAcak = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $pathFoto = $file->storeAs('menu', $namaBerkasAcak, 'public');
            $data['foto'] = $pathFoto;
        }

        Menu::create($data);

        return redirect()->route('admin.menu.index')
            ->with('success', "Menu '{$data['nama_menu']}' berhasil ditambahkan ke katalog.");
    }

    /**
     * Mengalihkan tampilan tunggal menu ke formulir pengeditan.
     */
    public function show(Menu $menu): RedirectResponse
    {
        return redirect()->route('admin.menu.edit', $menu);
    }

    /**
     * Menampilkan formulir penyuntingan hidangan menu.
     */
    public function edit(Menu $menu): View
    {
        $kategoriList = Menu::KATEGORI;

        return view('admin.menu.edit', compact('menu', 'kategoriList'));
    }

    /**
     * Memperbarui informasi hidangan menu dan mengelola penggantian berkas foto.
     */
    public function update(MenuRequest $request, Menu $menu): RedirectResponse
    {
        $data = $request->validated();

        // Penanganan penggantian foto baru
        if ($request->hasFile('foto')) {
            // Hapus berkas foto lama jika ada di penyimpanan
            if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
                Storage::disk('public')->delete($menu->foto);
            }

            $file = $request->file('foto');
            $namaBerkasAcak = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $pathFoto = $file->storeAs('menu', $namaBerkasAcak, 'public');
            $data['foto'] = $pathFoto;
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')
            ->with('success', "Data hidangan '{$menu->nama_menu}' berhasil diperbarui.");
    }

    /**
     * Menghapus hidangan menu dari basis data beserta berkas foto fisiknya.
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        $namaMenu = $menu->nama_menu;

        // Menghapus berkas foto fisik dari media penyimpanan public
        if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
            Storage::disk('public')->delete($menu->foto);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', "Menu '{$namaMenu}' beserta berkas fotonya berhasil dihapus.");
    }
}
