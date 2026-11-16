<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian audit kepatuhan menyeluruh (Project Compliance Test):
 * - Keberadaan meta title & meta description di seluruh rute publik dan dasbor admin
 * - Keberadaan CSRF token (@csrf) pada formulir mutasi
 * - Keberadaan atribut alt pada setiap tag <img>
 * - Otorisasi peran (Role-based access control)
 * - Tampilan penanganan galat HTTP 403 dan 404
 */
class ProjectAuditComplianceTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->owner = User::where('role', 'owner')->first();
        $this->admin = User::where('role', 'admin')->first();
    }

    /**
     * Memastikan seluruh halaman publik memiliki <title> dan <meta name="description"> yang valid.
     */
    public function test_seluruh_halaman_publik_memiliki_meta_title_dan_description(): void
    {
        $menu = Menu::first();

        $routes = [
            '/',
            '/menu',
            '/menu/' . $menu->id,
            '/lokasi',
            '/kontak',
        ];

        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);

            // Memeriksa keberadaan tag <title>
            $response->assertSee('<title>', false);
            // Memeriksa keberadaan tag <meta name="description"
            $response->assertSee('<meta name="description"', false);
        }
    }

    /**
     * Memastikan seluruh halaman admin memiliki <title> dan <meta name="description"> yang valid.
     */
    public function test_seluruh_halaman_admin_memiliki_meta_title_dan_description(): void
    {
        // 1. Halaman Login publik admin
        $loginRes = $this->get('/admin/login');
        $loginRes->assertStatus(200);
        $loginRes->assertSee('<title>', false);
        $loginRes->assertSee('<meta name="description"', false);

        // 2. Halaman terproteksi Owner
        $ownerRoutes = [
            '/admin',
            '/admin/menu',
            '/admin/promosi',
            '/admin/profil-usaha',
            '/admin/akun',
        ];

        foreach ($ownerRoutes as $route) {
            $response = $this->actingAs($this->owner)->get($route);
            $response->assertStatus(200);
            $response->assertSee('<title>', false);
            $response->assertSee('<meta name="description"', false);
        }
    }

    /**
     * Memastikan tag <img> yang di-render memiliki atribut alt.
     */
    public function test_gambar_yang_dirender_memiliki_atribut_alt(): void
    {
        $response = $this->get('/menu');
        $response->assertStatus(200);
        $content = $response->getContent();

        // Cari semua tag <img> dan pastikan memiliki atribut alt="..."
        preg_match_all('/<img[^>]+>/i', $content, $matches);
        foreach ($matches[0] as $imgTag) {
            $this->assertMatchesRegularExpression('/alt=[\'"][^\'"]*[\'"]/i', $imgTag, "Tag img '{$imgTag}' tidak memiliki atribut alt.");
        }
    }

    /**
     * Memastikan formulir mutasi admin menyertakan token CSRF.
     */
    public function test_seluruh_form_mutasi_memiliki_csrf_token(): void
    {
        $routes = [
            '/admin/login',
            '/admin/menu/create',
            '/admin/promosi/create',
            '/admin/akun/create',
            '/admin/profil-usaha',
        ];

        foreach ($routes as $route) {
            $response = ($route === '/admin/login')
                ? $this->get($route)
                : $this->actingAs($this->owner)->get($route);

            $response->assertStatus(200);
            // Input token CSRF yang dihasilkan oleh @csrf
            $response->assertSee('name="_token"', false);
        }
    }

    /**
     * Memastikan halaman galat 403 khusus menampilkan desain bertema dan title yang tepat.
     */
    public function test_halaman_galat_403_memiliki_title_dan_pesan_ramah(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/akun');
        $response->assertStatus(403);
        $response->assertSee('Akses Dibatasi (403)');
        $response->assertSee('Wewenang Dibatasi');
    }

    /**
     * Memastikan halaman galat 404 khusus menampilkan desain bertema dan title yang tepat.
     */
    public function test_halaman_galat_404_memiliki_title_dan_pesan_ramah(): void
    {
        $response = $this->get('/halaman-fiktif-tidak-ada');
        $response->assertStatus(404);
        $response->assertSee('Halaman Tidak Ditemukan (404)');
        $response->assertSee('Sajian Tidak Ditemukan');
    }
}

