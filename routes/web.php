<?php

use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProfilUsahaController;
use App\Http\Controllers\Admin\PromosiController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\LokasiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rute Publik (Pelanggan)
|--------------------------------------------------------------------------
| Dapat diakses secara terbuka tanpa login, dan tetap dapat diakses
| oleh pengguna yang sedang memiliki sesi login aktif.
*/
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/menu', [KatalogController::class, 'index'])->name('katalog');
Route::get('/menu/{menu}', [KatalogController::class, 'show'])->name('katalog.detail');
Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');

/*
|--------------------------------------------------------------------------
| Rute Autentikasi Pengelola (Admin & Owner)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Rute Dasbor & Manajemen Terproteksi (Prefix: /admin)
|--------------------------------------------------------------------------
| Mewajibkan sesi autentikasi 'auth'. Pembatasan hak akses berbasis peran
| ditangani oleh middleware 'role'.
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Rute yang dapat diakses oleh Owner dan Admin
    Route::middleware(['role:owner,admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('menu', MenuController::class);
        Route::resource('promosi', PromosiController::class);
        Route::get('/profil-usaha', [ProfilUsahaController::class, 'edit'])->name('profil-usaha.edit');
        Route::put('/profil-usaha', [ProfilUsahaController::class, 'update'])->name('profil-usaha.update');
    });

    // Rute khusus Owner (Admin yang mengakses kelola akun akan menerima respon 403 Forbidden)
    Route::middleware(['role:owner'])->group(function () {
        Route::resource('akun', AkunController::class);
    });
});
