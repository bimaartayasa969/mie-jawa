<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Pengujian operasi CRUD lengkap manajemen menu oleh Admin & Owner, termasuk unggah dan hapus foto fisik.
 */
class AdminMenuManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        Storage::fake('public');
    }

    /**
     * Memastikan Admin dapat melihat daftar menu dengan tabel kelola dan daftar visual.
     */
    public function test_admin_dapat_melihat_daftar_menu(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Tampilan tabel
        $responseTabel = $this->actingAs($admin)->get('/admin/menu?tampilan=tabel');
        $responseTabel->assertStatus(200);
        $responseTabel->assertSee('Daftar &amp; Kelola Menu', false);
        $responseTabel->assertSee('Tabel Kelola');
        $responseTabel->assertSee('Mie Godog');

        // Tampilan visual
        $responseVisual = $this->actingAs($admin)->get('/admin/menu?tampilan=visual');
        $responseVisual->assertStatus(200);
        $responseVisual->assertSee('Daftar Visual');
    }

    /**
     * Memastikan Admin dapat membuka formulir penambahan menu baru.
     */
    public function test_admin_dapat_membuka_halaman_tambah_menu(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/menu/create');

        $response->assertStatus(200);
        $response->assertSee('Tambah Menu Baru');
        $response->assertSee('Simpan Menu');
        $response->assertSee('Mie');
        $response->assertSee('Minuman');
        $response->assertSee('Tambahan');
    }

    /**
     * Memastikan menu baru berhasil disimpan beserta unggahan berkas foto acak dan created_by.
     */
    public function test_tambah_menu_berhasil_menyimpan_data_dan_berkas_foto_acak(): void
    {
        $admin = User::where('role', 'admin')->first();
        $fileFoto = UploadedFile::fake()->image('bakmi_spesial.jpg', 600, 400)->size(1024); // 1 MB

        $response = $this->actingAs($admin)->post('/admin/menu', [
            'nama_menu' => 'Bakmi Jawa Spesial Telur Bebek',
            'kategori' => 'Mie',
            'harga' => 28000,
            'deskripsi' => 'Bakmi kenyal dengan kuah kaldu bebek gurih dan aroma smokey arang.',
            'status_tersedia' => '1',
            'is_unggulan' => '1',
            'foto' => $fileFoto,
        ]);

        $response->assertRedirect(route('admin.menu.index'));
        $response->assertSessionHas('success');

        // Memeriksa basis data
        $menuBaru = Menu::where('nama_menu', 'Bakmi Jawa Spesial Telur Bebek')->first();
        $this->assertNotNull($menuBaru);
        $this->assertEquals($admin->id, $menuBaru->created_by);
        $this->assertEquals('Mie', $menuBaru->kategori);
        $this->assertEquals(28000, $menuBaru->harga);
        $this->assertEquals('tersedia', $menuBaru->status);
        $this->assertTrue($menuBaru->is_unggulan);
        $this->assertNotNull($menuBaru->foto);
        $this->assertStringStartsWith('menu/', $menuBaru->foto);

        // Memeriksa bahwa berkas fisik tersimpan di disk public
        Storage::disk('public')->assertExists($menuBaru->foto);
    }

    /**
     * Memastikan validasi input berbahasa Indonesia berfungsi jika data wajib tidak diisi.
     */
    public function test_validasi_tambah_menu_menampilkan_pesan_bahasa_indonesia(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/menu', [
            'nama_menu' => '',
            'kategori' => 'KategoriSalah',
            'harga' => -100,
        ]);

        $response->assertSessionHasErrors(['nama_menu', 'kategori', 'harga']);
        $errors = session('errors');
        $this->assertStringContainsString('Nama menu hidangan wajib diisi', $errors->first('nama_menu'));
        $this->assertStringContainsString('Kategori yang dipilih tidak valid', $errors->first('kategori'));
        $this->assertStringContainsString('tidak boleh bernilai negatif', $errors->first('harga'));
    }

    /**
     * Memastikan pembaruan menu berhasil dan foto lama terhapus jika diganti dengan foto baru.
     */
    public function test_perbarui_menu_mengganti_foto_dan_menghapus_foto_lama(): void
    {
        $admin = User::where('role', 'admin')->first();

        // 1. Buat menu awal dengan foto pertama
        $fotoLama = UploadedFile::fake()->image('foto_awal.jpg')->size(500);
        $pathFotoLama = $fotoLama->storeAs('menu', 'foto_lama.jpg', 'public');

        $menu = Menu::create([
            'created_by' => $admin->id,
            'nama_menu' => 'Mie Kluntung Khas Jawa',
            'kategori' => 'Mie',
            'harga' => 20000,
            'deskripsi' => 'Deskripsi lama.',
            'status' => 'tersedia',
            'is_unggulan' => false,
            'foto' => $pathFotoLama,
        ]);

        Storage::disk('public')->assertExists($pathFotoLama);

        // 2. Unggah foto baru pengganti
        $fotoBaru = UploadedFile::fake()->image('foto_baru.webp')->size(800);

        $response = $this->actingAs($admin)->put('/admin/menu/' . $menu->id, [
            'nama_menu' => 'Mie Kluntung Khas Jawa Super',
            'kategori' => 'Mie',
            'harga' => 23000,
            'deskripsi' => 'Deskripsi baru yang diperbarui.',
            'status_tersedia' => '1',
            'is_unggulan' => '1',
            'foto' => $fotoBaru,
        ]);

        $response->assertRedirect(route('admin.menu.index'));
        $response->assertSessionHas('success');

        $menu->refresh();
        $this->assertEquals('Mie Kluntung Khas Jawa Super', $menu->nama_menu);
        $this->assertEquals(23000, $menu->harga);
        $this->assertTrue($menu->is_unggulan);

        // Foto lama harus terhapus dari storage
        Storage::disk('public')->assertMissing($pathFotoLama);
        // Foto baru harus ada di storage
        Storage::disk('public')->assertExists($menu->foto);
    }

    /**
     * Memastikan penghapusan menu menghapus data di database serta menghapus berkas fotonya dari server.
     */
    public function test_hapus_menu_menghapus_data_dan_berkas_foto_fisik(): void
    {
        $admin = User::where('role', 'admin')->first();

        // Siapkan menu dengan berkas foto
        $foto = UploadedFile::fake()->image('mie_dihapus.jpg');
        $pathFoto = $foto->storeAs('menu', 'mie_dihapus.jpg', 'public');

        $menu = Menu::create([
            'created_by' => $admin->id,
            'nama_menu' => 'Menu Siap Hapus',
            'kategori' => 'Tambahan',
            'harga' => 15000,
            'deskripsi' => 'Akan segera dihapus.',
            'status' => 'tersedia',
            'is_unggulan' => false,
            'foto' => $pathFoto,
        ]);

        Storage::disk('public')->assertExists($pathFoto);

        // Jalankan aksi delete
        $response = $this->actingAs($admin)->delete('/admin/menu/' . $menu->id);

        $response->assertRedirect(route('admin.menu.index'));
        $response->assertSessionHas('success');

        // Pastikan menu terhapus dari database
        $this->assertDatabaseMissing('menu', ['id' => $menu->id]);

        // Pastikan berkas foto fisik terhapus dari storage
        Storage::disk('public')->assertMissing($pathFoto);
    }
}

