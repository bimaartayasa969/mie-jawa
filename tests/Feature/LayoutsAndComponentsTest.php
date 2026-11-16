<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian integrasi tata letak (layouts/app, layouts/admin) dan komponen UI (navbar, footer, kartu-menu, alert).
 */
class LayoutsAndComponentsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Memastikan halaman publik merender layout app dengan komponen navbar, kartu menu, dan footer.
     */
    public function test_halaman_beranda_merender_layout_publik_dan_komponen(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Memeriksa komponen navbar
        $response->assertSee('Mie Jawa');
        $response->assertSee('MASAK ANGLO ARANG');
        $response->assertSee('Tanya via WhatsApp');
        // Memeriksa kartu menu unggulan
        $response->assertSee('4 Menu Unggulan Warung');
        $response->assertSee('Mie Godog');
        // Memeriksa komponen footer
        $response->assertSee('Halaman Publik');
        $response->assertSee('Jam Operasional');
        $response->assertSee('Hubungi Kami');
        $response->assertSee('Seluruh hak cipta dilindungi');
    }

    /**
     * Memastikan layout admin merender navigasi sidebar lengkap khusus Owner.
     */
    public function test_layout_admin_merender_menu_lengkap_untuk_owner(): void
    {
        $owner = User::where('role', 'owner')->first();

        $response = $this->actingAs($owner)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('PERAN: OWNER');
        $response->assertSee('Dashboard');
        $response->assertSee('Daftar &amp; Kelola Menu', false);
        $response->assertSee('Banner Promosi');
        $response->assertSee('Profil Usaha');
        $response->assertSee('Kelola Akun Admin');
        $response->assertSee('Lihat Website Publik');
        $response->assertSee('Keluar (Pemilik Usaha)');
    }

    /**
     * Memastikan layout admin menampilkan dashboard, menu, promosi, profil, namun menyembunyikan kelola akun untuk Admin.
     */
    public function test_layout_admin_menyembunyikan_kelola_akun_dari_admin(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/menu');

        $response->assertStatus(200);
        $response->assertSee('PERAN: ADMIN');
        $response->assertSee('Dashboard');
        $response->assertSee('Daftar &amp; Kelola Menu', false);
        $response->assertSee('Banner Promosi');
        $response->assertSee('Profil Usaha');
        $response->assertSee('Lihat Website Publik');
        $response->assertSee('Keluar (Administrator)');

        // Kelola Akun Admin hanya untuk Owner, disembunyikan dari sidebar Admin
        $response->assertDontSee('Kelola Akun Admin');
    }
}

