<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\ProfilUsaha;
use App\Models\Promosi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder utama aplikasi untuk mengisi data awal UMKM Mie Jawa.
 * Menginisialisasi akun Owner & Admin, profil usaha, promosi aktif, serta menu hidangan placeholder.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan proses seeding basis data.
     */
    public function run(): void
    {
        // Mengambil kata sandi awal dari .env (fallback ke default jika belum disetel)
        $rawPassword = env('DEFAULT_PASSWORD', 'MieJawa#2026');
        $passwordHash = Hash::make($rawPassword);

        // 1. Akun Pemilik Usaha (Owner)
        $owner = User::firstOrCreate(
            ['email' => 'pemilik@miejawa.com'],
            [
                'nama' => 'Bima Artayasa',
                'password' => $passwordHash,
                'role' => 'owner',
            ]
        );

        // 2. Akun Administrator (Admin)
        $admin = User::firstOrCreate(
            ['email' => 'admin@miejawa.com'],
            [
                'nama' => 'Admin Pengelola Warung',
                'password' => $passwordHash,
                'role' => 'admin',
            ]
        );

        // 3. Satu Data Profil Usaha (Entitas baris tunggal)
        $profil = ProfilUsaha::first();
        if (! $profil) {
            ProfilUsaha::create([
                'updated_by' => $owner->id,
                'nama_usaha' => 'Mie Jawa Masak Anglo Arang',
                'deskripsi' => 'Warung kuliner Mie Jawa bercita rasa autentik. Diracik dengan bumbu rempah ulekan segar, kaldu ayam kampung gurih, dan dimasak langsung menggunakan wajan anglo arang.',
                'alamat' => 'Jl. Sultan Abdurrahman, Mie Goreng Jawa, Pontianak, Kalimantan Barat',
                'latitude' => -0.03550000,
                'longitude' => 109.33100000,
                'no_whatsapp' => '081549077231',
                'instagram' => '@miejawa.official',
                'jam_operasional' => 'Senin - Sabtu: 18.00 - 22.00 WIB | Minggu: Tutup / Libur',
                'logo' => null,
            ]);
        }

        // 4. Satu Data Promosi Awal
        if (Promosi::count() === 0) {
            Promosi::create([
                'created_by' => $owner->id,
                'judul' => 'Promo Traktiran Sore: Diskon 15% Jam 16:00 - 18:00',
                'deskripsi' => 'Nikmati diskon spesial 15% untuk setiap pembelian menu mie kuah atau goreng pada jam santai sore hari.',
                'banner' => null,
                'tanggal_mulai' => now()->subDays(3)->toDateString(),
                'tanggal_selesai' => now()->addDays(30)->toDateString(),
                'is_aktif' => true,
            ]);
        }

        // 5. Enam Data Menu Contoh Placeholder
        $daftarMenu = [
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Mie Godog',
                'kategori' => 'Mie',
                'deskripsi' => 'Mie rebus dengan kuah kaldu ayam kampung kental gurih, suwiran ayam melimpah, telur, sayuran kol, wortel, dan tomat segar dengan aroma wajan anglo arang.',
                'harga' => 25000,
                'foto' => 'menu/bWIhOzQmXm2WPgPxLCIp3eik2Fkdc4HlyIJi7LOq.jpg',
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Mie Goreng',
                'kategori' => 'Mie',
                'deskripsi' => 'Mie kuning kenyal ditumis dengan bumbu ulekan rempah bawang dan kemiri, kecap manis, telur, suwiran ayam, dan acar segar.',
                'harga' => 24000,
                'foto' => null,
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Soto Ayam',
                'kategori' => 'Mie',
                'deskripsi' => 'Soto ayam berkuah kaldu ayam kampung bening gurih segar, suwiran daging ayam melimpah, soun lembut, irisan kol, dan taburan koya.',
                'harga' => 22000,
                'foto' => null,
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Nasi Goreng',
                'kategori' => 'Mie',
                'deskripsi' => 'Nasi goreng dengan aroma wajan anglo arang sedap, bumbu rempah tradisional gurih, suwiran ayam, dan telur orak-arik.',
                'harga' => 24000,
                'foto' => null,
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Nasi Mawut',
                'kategori' => 'Mie',
                'deskripsi' => 'Perpaduan nasi goreng dan mie dimasak di atas wajan anglo arang dengan bumbu istimewa, suwiran ayam, dan telur.',
                'harga' => 25000,
                'foto' => null,
                'status' => 'tersedia',
                'is_unggulan' => false,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Wedang Jahe Rempah',
                'kategori' => 'Minuman',
                'deskripsi' => 'Minuman tradisional hangat dari rebusan jahe emprit, serai, cengkeh, dan gula aren asli penyegar badan.',
                'harga' => 10000,
                'foto' => null,
                'status' => 'tersedia',
                'is_unggulan' => false,
            ],
        ];

        foreach ($daftarMenu as $item) {
            Menu::firstOrCreate(['nama_menu' => $item['nama_menu']], $item);
        }
    }
}
