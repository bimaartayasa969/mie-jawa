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
        ProfilUsaha::updateOrCreate(
            ['id' => 1],
            [
                'updated_by' => $owner->id,
                'nama_usaha' => 'Mie Jawa Masak Anglo Arang',
                'deskripsi' => 'Warung kuliner Mie Jawa bercita rasa autentik. Diracik dengan bumbu rempah ulekan segar, kaldu ayam kampung gurih, dan dimasak langsung menggunakan wajan anglo arang.',
                'alamat' => 'Jl. Sultan Abdurrahman, Mie Goreng Jawa, Pontianak, Kalimantan Barat',
                'latitude' => -0.03550000,
                'longitude' => 109.33100000,
                'no_whatsapp' => '083845863186',
                'instagram' => '@miejawa.official',
                'jam_operasional' => 'Senin - Sabtu: 18.00 - 22.00 WIB | Minggu: Tutup / Libur',
                'logo' => null,
            ]
        );

        // 4. Data Promosi Awal (Daftar Menu & Promo)
        Promosi::updateOrCreate(
            ['id' => 1],
            [
                'created_by' => $owner->id,
                'judul' => 'Daftar Menu & Sajian Spesial Masak Anglo Arang',
                'deskripsi' => 'Nikmati sajian autentik Mie Goreng, Mie Godog, Nasi Mawut, Nasi Goreng, hingga Soto Ayam mulai Rp 13.000. Dimasak satu per satu menggunakan wajan anglo arang tradisional.',
                'banner' => 'promosi/daftar_menu_banner.jpg',
                'tanggal_mulai' => now()->subDays(3)->toDateString(),
                'tanggal_selesai' => now()->addDays(90)->toDateString(),
                'is_aktif' => true,
            ]
        );

        // 5. Daftar Menu Kuliner Sesuai Daftar Menu & Foto Resmi Warung
        $daftarMenu = [
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Mie Goreng',
                'kategori' => 'Mie',
                'deskripsi' => 'Mie kuning kenyal ditumis dengan bumbu ulekan rempah bawang dan kemiri, kecap manis, telur, suwiran ayam, dan acar timun segar dimasak di atas wajan anglo arang.',
                'harga' => 13000,
                'foto' => 'menu/mie_goreng.jpg',
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Mie Goreng Spesial',
                'kategori' => 'Mie',
                'deskripsi' => 'Porsi spesial mie goreng dengan suwiran ayam kampung ekstra melimpah, telur ceplok/dadar istimewa, sayuran segar, dan bumbu rempah autentik anglo arang.',
                'harga' => 23000,
                'foto' => 'menu/mie_goreng.jpg',
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Mie Godog',
                'kategori' => 'Mie',
                'deskripsi' => 'Mie rebus khas Jawa dengan kuah kaldu ayam gurih kental sedap, suwiran ayam kampung, sayuran kol, wortel, telur bebek/ayam, dan taburan bawang goreng harum.',
                'harga' => 13000,
                'foto' => 'menu/mie_godog.jpg',
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Mie Godog Spesial',
                'kategori' => 'Mie',
                'deskripsi' => 'Porsi spesial mie godog dengan kuah kaldu ayam kampung pekat gurih, suwiran daging ayam porsi dobel, telur bebek istimewa, sayuran segar, dan aroma wajan anglo arang.',
                'harga' => 23000,
                'foto' => 'menu/mie_godog.jpg',
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Nasi Goreng',
                'kategori' => 'Tambahan',
                'deskripsi' => 'Nasi goreng aroma sangit wajan anglo arang yang sedap, dimasak dengan bumbu halus rempah tradisional, suwiran ayam, telur orak-arik, dan irisan timun renyah.',
                'harga' => 13000,
                'foto' => 'menu/nasi_goreng.jpg',
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Nasi Goreng Spesial',
                'kategori' => 'Tambahan',
                'deskripsi' => 'Nasi goreng porsi spesial dengan suwiran ayam kampung melimpah, telur mata sapi/dadar, bumbu racikan khas anglo arang, dan acar timun segar.',
                'harga' => 23000,
                'foto' => 'menu/nasi_goreng.jpg',
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Nasi Mawut',
                'kategori' => 'Tambahan',
                'deskripsi' => 'Perpaduan mantap nasi goreng dan mie kuning dimasak bersama bumbu rempah ulekan di atas arang menyala, disajikan dengan suwiran ayam dan acar timun segar.',
                'harga' => 13000,
                'foto' => 'menu/nasi_mawut.jpg',
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Soto Ayam (+ Nasi Pisah)',
                'kategori' => 'Tambahan',
                'deskripsi' => 'Soto ayam berkuah kaldu kuning bening segar gurih dengan suwiran daging ayam, tomat segar, soun lembut, tauge, kol, dan taburan bawang goreng, disajikan lengkap dengan sepiring nasi putih terpisah.',
                'harga' => 15000,
                'foto' => 'menu/soto_ayam.jpg',
                'status' => 'tersedia',
                'is_unggulan' => true,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Sop Ayam (+ Nasi)',
                'kategori' => 'Tambahan',
                'deskripsi' => 'Sup ayam kuah kaldu bening kaya rempah penghangat tubuh dengan potongan ayam empuk, wortel, kentang, buncis, dan daun seledri harum, disajikan dengan nasi putih.',
                'harga' => 19000,
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
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Es Jeruk Peras',
                'kategori' => 'Minuman',
                'deskripsi' => 'Perasan jeruk murni asli dengan es batu segar kaya vitamin C penyegar suasana.',
                'harga' => 7000,
                'foto' => null,
                'status' => 'tersedia',
                'is_unggulan' => false,
            ],
            [
                'created_by' => $owner->id,
                'nama_menu' => 'Es Teh Manis',
                'kategori' => 'Minuman',
                'deskripsi' => 'Teh seduh melati segar dan manis dingin pelepas dahaga yang nikmat diminum bersama aneka hidangan mie.',
                'harga' => 5000,
                'foto' => null,
                'status' => 'tersedia',
                'is_unggulan' => false,
            ],
        ];

        // Hapus entri lama 'Soto Ayam' agar digantikan oleh format lengkap 'Soto Ayam (+ Nasi Pisah)'
        Menu::where('nama_menu', 'Soto Ayam')->delete();

        foreach ($daftarMenu as $item) {
            Menu::updateOrCreate(['nama_menu' => $item['nama_menu']], $item);
        }
    }
}
