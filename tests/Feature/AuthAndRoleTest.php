<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

/**
 * Pengujian fitur autentikasi, pembatasan throttle, dan otorisasi peran (RoleMiddleware).
 */
class AuthAndRoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Jalankan seeder agar data Owner dan Admin terisi di basis data pengujian
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Memastikan halaman login dapat diakses oleh publik (guest).
     */
    public function test_halaman_login_dapat_dibuka_oleh_tamu(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Masuk Dasbor Pengelolaan');
        $response->assertSee('PORTAL AKTOR SISTEM');
    }

    /**
     * Memastikan tamu tanpa login yang membuka rute admin dialihkan ke /admin/login.
     */
    public function test_tamu_dialihkan_ke_login_saat_mengakses_rute_admin(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/admin/login');

        $responseMenu = $this->get('/admin/menu');
        $responseMenu->assertRedirect('/admin/login');

        $responsePromosi = $this->get('/admin/promosi');
        $responsePromosi->assertRedirect('/admin/login');
    }

    /**
     * Memastikan Owner setelah login diarahkan ke /admin dan dapat membuka halaman khusus Owner.
     */
    public function test_owner_diarahkan_ke_dashboard_setelah_login(): void
    {
        $owner = User::where('role', 'owner')->first();
        $this->assertNotNull($owner);

        // Tes submit login
        $response = $this->post('/admin/login', [
            'email' => $owner->email,
            'password' => 'MieJawa#2026',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($owner);

        // Owner dapat membuka /admin
        $dashResponse = $this->actingAs($owner)->get('/admin');
        $dashResponse->assertStatus(200);
        $dashResponse->assertSee('Dasbor Pemilik Usaha (Owner)');

        // Owner dapat membuka /admin/menu
        $menuResponse = $this->actingAs($owner)->get('/admin/menu');
        $menuResponse->assertStatus(200);

        // Owner dapat membuka /admin/promosi
        $promosiResponse = $this->actingAs($owner)->get('/admin/promosi');
        $promosiResponse->assertStatus(200);
    }

    /**
     * Memastikan Admin setelah login diarahkan ke dashboard dan dapat mengakses menu, promosi, serta profil,
     * tetapi ditolak 403 Forbidden pada kelola akun (hanya Owner).
     */
    public function test_admin_dapat_akses_semua_halaman_kecuali_kelola_akun(): void
    {
        $admin = User::where('role', 'admin')->first();
        $this->assertNotNull($admin);

        // Tes submit login
        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => 'MieJawa#2026',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);

        // Admin dapat membuka /admin (dashboard)
        $dashResponse = $this->actingAs($admin)->get('/admin');
        $dashResponse->assertStatus(200);

        // Admin dapat membuka /admin/menu
        $menuResponse = $this->actingAs($admin)->get('/admin/menu');
        $menuResponse->assertStatus(200);
        $menuResponse->assertSee('Daftar & Kelola Menu');

        // Admin dapat membuka /admin/promosi
        $promosiResponse = $this->actingAs($admin)->get('/admin/promosi');
        $promosiResponse->assertStatus(200);

        // Admin dapat membuka /admin/profil-usaha
        $profilResponse = $this->actingAs($admin)->get('/admin/profil-usaha');
        $profilResponse->assertStatus(200);

        // Admin yang membuka /admin/akun HARUS mendapat 403 Forbidden
        $akunResponse = $this->actingAs($admin)->get('/admin/akun');
        $akunResponse->assertStatus(403);
    }

    /**
     * Memastikan pembatasan percobaan login (throttling) berfungsi setelah 5 kali gagal.
     */
    public function test_throttle_login_berfungsi_setelah_percobaan_gagal(): void
    {
        RateLimiter::clear('admin@miejawa.com|127.0.0.1');

        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', [
                'email' => 'admin@miejawa.com',
                'password' => 'salah123',
            ]);
        }

        // Percobaan ke-6 harus gagal dengan pesan throttle
        $response = $this->post('/admin/login', [
            'email' => 'admin@miejawa.com',
            'password' => 'salah123',
        ]);

        $response->assertSessionHasErrors('email');
        $errors = session('errors')->get('email');
        $this->assertStringContainsString('Terlalu banyak percobaan masuk', $errors[0]);

        RateLimiter::clear('admin@miejawa.com|127.0.0.1');
    }

    /**
     * Memastikan pengguna dapat logout dan sesi dibersihkan.
     */
    public function test_pengguna_dapat_logout(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/logout');

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
