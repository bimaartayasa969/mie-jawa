<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\ProfilUsaha;
use App\Models\Promosi;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian fitur seluruh halaman publik (Beranda, Katalog, Detail Menu, Lokasi, dan Kontak).
 */
class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Memastikan Beranda menampilkan profil, banner promosi aktif, dan 4 menu unggulan.
     */
    public function test_beranda_menampilkan_profil_promosi_aktif_dan_menu_unggulan(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        // Profil singkat dari basis data
        $response->assertSee('Mie Jawa Masak Anglo Arang');
        $response->assertSee('Cita Rasa Gurih Mie Jawa Masak Arang');
        // Promosi aktif yang sedang berlaku
        $response->assertSee('Promo Traktiran Sore');
        $response->assertSee('Klaim Promo via WhatsApp');
        // 4 Menu unggulan
        $response->assertSee('4 Menu Unggulan Warung');
        $response->assertSee('Mie Godog');
        $response->assertSee('Mie Goreng');
        $response->assertSee('Soto Ayam');
        $response->assertSee('Nasi Goreng');
    }

    /**
     * Memastikan promosi yang dinonaktifkan atau kedaluwarsa tidak muncul di beranda.
     */
    public function test_promosi_tidak_aktif_tidak_muncul_di_beranda(): void
    {
        // Nonaktifkan semua promosi
        Promosi::query()->update(['is_aktif' => false]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('Promo Traktiran Sore');
    }

    /**
     * Memastikan Katalog menu menampilkan daftar lengkap, fitur filter kategori, dan pencarian.
     */
    public function test_katalog_menampilkan_menu_dan_berfungsi_filter_serta_pencarian(): void
    {
        // 1. Tampilan katalog default
        $response = $this->get('/menu');
        $response->assertStatus(200);
        $response->assertSee('Katalog Menu Mie Jawa');
        $response->assertSee('Mie Godog');
        $response->assertSee('Wedang Jahe Rempah');

        // 2. Filter kategori 'Minuman'
        $responseMinuman = $this->get('/menu?kategori=Minuman');
        $responseMinuman->assertStatus(200);
        $responseMinuman->assertSee('Wedang Jahe Rempah');
        $responseMinuman->assertDontSee('Mie Godog');

        // 3. Pencarian kata kunci 'Godog'
        $responseCari = $this->get('/menu?cari=Godog');
        $responseCari->assertStatus(200);
        $responseCari->assertSee('Mie Godog');
        $responseCari->assertDontSee('Soto Ayam');
    }

    /**
     * Memastikan Halaman Detail Menu menampilkan foto, harga, deskripsi, status, dan tombol WA.
     */
    public function test_detail_menu_menampilkan_informasi_lengkap_dan_tombol_wa(): void
    {
        $menu = Menu::where('nama_menu', 'Mie Godog')->first();
        $this->assertNotNull($menu);

        $response = $this->get('/menu/' . $menu->id);

        $response->assertStatus(200);
        $response->assertSee('Mie Godog');
        $response->assertSee('Rp 25.000');
        $response->assertSee('kaldu ayam kampung');
        $response->assertSee('Siap Saji Hari Ini');
        $response->assertSee('Pesan / Tanya via WhatsApp');
        $response->assertSee('https://wa.me/', false);
    }

    /**
     * Memastikan Halaman Lokasi menampilkan Google Maps embed berdasarkan koordinat database.
     */
    public function test_halaman_lokasi_menampilkan_peta_embed_dan_koordinat_database(): void
    {
        $profil = ProfilUsaha::first();
        $this->assertNotNull($profil);

        $response = $this->get('/lokasi');

        $response->assertStatus(200);
        $response->assertSee('Lokasi &amp; Jam Operasional', false);
        $response->assertSee($profil->alamat);
        $response->assertSee('18.00 – 22.00 WIB', false);
        // Memeriksa iframe maps google embed dengan koordinat latitude & longitude
        $response->assertSee('maps.google.com/maps?q=' . $profil->latitude . ',' . $profil->longitude, false);
    }

    /**
     * Memastikan Halaman Kontak menampilkan informasi kontak dan form pengiriman WhatsApp.
     */
    public function test_halaman_kontak_menampilkan_informasi_dan_formulir_wa(): void
    {
        $profil = ProfilUsaha::first();
        $this->assertNotNull($profil);

        $response = $this->get('/kontak');

        $response->assertStatus(200);
        $response->assertSee('Kontak &amp; Informasi Warung', false);
        $response->assertSee($profil->no_whatsapp);
        $response->assertSee($profil->instagram);
        $response->assertSee('Kirim Pesan Langsung ke WhatsApp');
        $response->assertSee('Kirim via WhatsApp');
    }
}

