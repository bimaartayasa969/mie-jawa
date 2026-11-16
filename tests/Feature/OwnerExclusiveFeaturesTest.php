<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\ProfilUsaha;
use App\Models\Promosi;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Pengujian komprehensif fitur khusus Owner (role:owner):
 * - Dashboard: ringkasan metrik total menu, menu habis, dan promosi aktif
 * - Promosi: CRUD lengkap, created_by, unggah & hapus berkas banner
 * - Profil Usaha: edit & update, updated_by, unggah & hapus berkas logo
 * - Kelola Akun: CRUD akun admin, hash kata sandi, proteksi larangan menghapus akun owner
 * - Aksesibilitas peran: Admin menerima 403 Forbidden pada seluruh rute khusus Owner
 */
class OwnerExclusiveFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        Storage::fake('public');

        $this->owner = User::where('role', 'owner')->first();
        $this->admin = User::where('role', 'admin')->first();
    }

    /*
    |--------------------------------------------------------------------------
    | 1. Pengujian Dasbor Metrik Owner
    |--------------------------------------------------------------------------
    */

    public function test_owner_dapat_melihat_ringkasan_metrik_di_dashboard(): void
    {
        $response = $this->actingAs($this->owner)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Ringkasan Bisnis &amp; Finansial', false);
        $response->assertSee('Total Sajian Menu');
        $response->assertSee('Menu Habis');
        $response->assertSee('Promosi Aktif');
        $response->assertSee('Lihat Website');
    }

    public function test_admin_dapat_melihat_ringkasan_metrik_di_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Ringkasan Bisnis &amp; Finansial', false);
        $response->assertSee('Total Sajian Menu');
        $response->assertSee('Menu Habis');
        $response->assertSee('Promosi Aktif');
    }

    /*
    |--------------------------------------------------------------------------
    | 2. Pengujian CRUD Promosi & Banner
    |--------------------------------------------------------------------------
    */

    public function test_owner_dapat_melihat_daftar_promosi(): void
    {
        $response = $this->actingAs($this->owner)->get('/admin/promosi');

        $response->assertStatus(200);
        $response->assertSee('Kelola Banner Promosi');
        $response->assertSee('Tambah Banner Promosi');
    }

    public function test_owner_dapat_menambah_promosi_baru_dengan_banner(): void
    {
        $banner = UploadedFile::fake()->image('promo_diskon.webp', 1200, 400)->size(1500);

        $response = $this->actingAs($this->owner)->post('/admin/promosi', [
            'judul' => 'Promo Buka Puasa Traktiran Es Teh',
            'deskripsi' => 'Setiap pembelian 2 porsi mie goreng mendapatkan gratis 1 es teh manis.',
            'tanggal_mulai' => now()->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(5)->format('Y-m-d'),
            'is_aktif' => '1',
            'banner' => $banner,
        ]);

        $response->assertRedirect(route('admin.promosi.index'));
        $response->assertSessionHas('sukses');

        $promosiBaru = Promosi::where('judul', 'Promo Buka Puasa Traktiran Es Teh')->first();
        $this->assertNotNull($promosiBaru);
        $this->assertEquals($this->owner->id, $promosiBaru->created_by);
        $this->assertTrue($promosiBaru->is_aktif);
        $this->assertNotNull($promosiBaru->banner);

        Storage::disk('public')->assertExists($promosiBaru->banner);
    }

    public function test_owner_dapat_mengubah_promosi_dan_mengganti_banner(): void
    {
        $promosi = Promosi::first();
        $bannerBaru = UploadedFile::fake()->image('banner_baru.jpg', 800, 300)->size(800);

        $response = $this->actingAs($this->owner)->put('/admin/promosi/' . $promosi->id, [
            'judul' => 'Judul Promo Telah Diubah',
            'deskripsi' => 'Deskripsi baru promosi.',
            'tanggal_mulai' => now()->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(10)->format('Y-m-d'),
            'is_aktif' => '1',
            'banner' => $bannerBaru,
        ]);

        $response->assertRedirect(route('admin.promosi.index'));
        $response->assertSessionHas('sukses');

        $promosi->refresh();
        $this->assertEquals('Judul Promo Telah Diubah', $promosi->judul);
        $this->assertNotNull($promosi->banner);
        Storage::disk('public')->assertExists($promosi->banner);
    }

    public function test_owner_dapat_menghapus_promosi_dan_berkas_bannernya(): void
    {
        $banner = UploadedFile::fake()->image('banner_hapus.jpg');
        $pathBanner = $banner->storeAs('promosi', 'banner_hapus.jpg', 'public');

        $promosi = Promosi::create([
            'created_by' => $this->owner->id,
            'judul' => 'Promo Akan Dihapus',
            'deskripsi' => 'Akan segera dihapus.',
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addDays(2),
            'is_aktif' => true,
            'banner' => $pathBanner,
        ]);

        Storage::disk('public')->assertExists($pathBanner);

        $response = $this->actingAs($this->owner)->delete('/admin/promosi/' . $promosi->id);

        $response->assertRedirect(route('admin.promosi.index'));
        $response->assertSessionHas('sukses');

        $this->assertDatabaseMissing('promosi', ['id' => $promosi->id]);
        Storage::disk('public')->assertMissing($pathBanner);
    }

    public function test_admin_dapat_mengakses_promosi(): void
    {
        $responseIndex = $this->actingAs($this->admin)->get('/admin/promosi');
        $responseIndex->assertStatus(200);

        $responseCreate = $this->actingAs($this->admin)->get('/admin/promosi/create');
        $responseCreate->assertStatus(200);
    }

    /*
    |--------------------------------------------------------------------------
    | 3. Pengujian Profil Usaha (Hanya Edit dan Update)
    |--------------------------------------------------------------------------
    */

    public function test_owner_dapat_melihat_halaman_edit_profil_usaha(): void
    {
        $response = $this->actingAs($this->owner)->get('/admin/profil-usaha');

        $response->assertStatus(200);
        $response->assertSee('Pengaturan Profil Usaha');
        $response->assertSee('Identitas &amp; Slogan Warung', false);
        $response->assertSee('Simpan Informasi Profil');
    }

    public function test_owner_dapat_memperbarui_profil_usaha_dan_mengisi_updated_by(): void
    {
        $logo = UploadedFile::fake()->image('logo_warung.png', 400, 400)->size(500);

        $response = $this->actingAs($this->owner)->put('/admin/profil-usaha', [
            'nama_usaha' => 'Mie Jawa Cabang Pontianak Barat',
            'deskripsi' => 'Masak Arang Tradisional Gurih Mantap',
            'alamat' => 'Jl. Kom Yos Sudarso No. 12, Pontianak Barat',
            'latitude' => -0.021000,
            'longitude' => 109.320000,
            'no_whatsapp' => '081255566677',
            'instagram' => '@miejawa.pontianak',
            'jam_operasional' => 'Senin - Sabtu: 17.00 - 23.30 WIB',
            'logo' => $logo,
        ]);

        $response->assertRedirect(route('admin.profil-usaha.edit'));
        $response->assertSessionHas('sukses');

        $profil = ProfilUsaha::first();
        $this->assertEquals('Mie Jawa Cabang Pontianak Barat', $profil->nama_usaha);
        $this->assertEquals($this->owner->id, $profil->updated_by);
        $this->assertEquals('081255566677', $profil->no_whatsapp);
        $this->assertNotNull($profil->logo);
        Storage::disk('public')->assertExists($profil->logo);
    }

    public function test_admin_dapat_mengakses_dan_memperbarui_profil_usaha(): void
    {
        $responseEdit = $this->actingAs($this->admin)->get('/admin/profil-usaha');
        $responseEdit->assertStatus(200);

        $responseUpdate = $this->actingAs($this->admin)->put('/admin/profil-usaha', [
            'nama_usaha' => 'Mie Jawa Cabang Pontianak Baru',
            'alamat' => 'Jl. Sultan Abdurrahman, Pontianak',
            'no_whatsapp' => '08123456789',
        ]);
        $responseUpdate->assertRedirect(route('admin.profil-usaha.edit'));
        $responseUpdate->assertSessionHas('sukses');
    }

    /*
    |--------------------------------------------------------------------------
    | 4. Pengujian Manajemen Akun Admin & Proteksi Owner
    |--------------------------------------------------------------------------
    */

    public function test_owner_dapat_melihat_daftar_akun_pengelola(): void
    {
        $response = $this->actingAs($this->owner)->get('/admin/akun');

        $response->assertStatus(200);
        $response->assertSee('Kelola Akun Administrator');
        $response->assertSee($this->owner->nama);
        $response->assertSee($this->admin->nama);
    }

    public function test_owner_dapat_mendaftarkan_akun_admin_baru_dengan_password_terhash(): void
    {
        $response = $this->actingAs($this->owner)->post('/admin/akun', [
            'nama' => 'Staf Baru Bagian Dapur',
            'email' => 'staf.dapur@miejawa.com',
            'password' => 'RahasiaStaf123',
        ]);

        $response->assertRedirect(route('admin.akun.index'));
        $response->assertSessionHas('sukses');

        $akunBaru = User::where('email', 'staf.dapur@miejawa.com')->first();
        $this->assertNotNull($akunBaru);
        $this->assertEquals('admin', $akunBaru->role);
        $this->assertTrue(Hash::check('RahasiaStaf123', $akunBaru->password));
    }

    public function test_owner_dapat_mengubah_data_dan_password_akun_admin(): void
    {
        $response = $this->actingAs($this->owner)->put('/admin/akun/' . $this->admin->id, [
            'nama' => 'Admin Utama Warung (Updated)',
            'email' => 'admin.updated@miejawa.com',
            'password' => 'KataSandiBaru2026',
        ]);

        $response->assertRedirect(route('admin.akun.index'));
        $response->assertSessionHas('sukses');

        $this->admin->refresh();
        $this->assertEquals('Admin Utama Warung (Updated)', $this->admin->nama);
        $this->assertEquals('admin.updated@miejawa.com', $this->admin->email);
        $this->assertTrue(Hash::check('KataSandiBaru2026', $this->admin->password));
    }

    public function test_owner_tidak_dapat_menghapus_akunnya_sendiri(): void
    {
        // Mencoba menghapus akun owner sendiri
        $response = $this->actingAs($this->owner)->delete('/admin/akun/' . $this->owner->id);

        $response->assertRedirect(route('admin.akun.index'));
        $response->assertSessionHas('gagal');

        // Pastikan akun owner tetap ada di basis data
        $this->assertDatabaseHas('users', ['id' => $this->owner->id]);
    }

    public function test_owner_dapat_menghapus_akun_admin_staf(): void
    {
        $adminStaff = User::create([
            'nama' => 'Staf Percobaan',
            'email' => 'percobaan@miejawa.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($this->owner)->delete('/admin/akun/' . $adminStaff->id);

        $response->assertRedirect(route('admin.akun.index'));
        $response->assertSessionHas('sukses');

        $this->assertDatabaseMissing('users', ['id' => $adminStaff->id]);
    }

    public function test_admin_mendapat_403_saat_mengakses_manajemen_akun(): void
    {
        $responseIndex = $this->actingAs($this->admin)->get('/admin/akun');
        $responseIndex->assertStatus(403);

        $responseCreate = $this->actingAs($this->admin)->get('/admin/akun/create');
        $responseCreate->assertStatus(403);

        $responseDelete = $this->actingAs($this->admin)->delete('/admin/akun/' . $this->admin->id);
        $responseDelete->assertStatus(403);
    }
}
