# Proyek: Website Katalog Promosi UMKM Mie Jawa

## 1. Konteks
- Website katalog dan promosi (menu, harga, foto, lokasi, kontak) untuk UMKM Mie Jawa. Proyek akhir mata kuliah Kewirausahaan, metode Waterfall.
- Sumber kebenaran: docs/PRD.md dan docs/BAB-III.md. Mockup di docs/mockup/.
- Jangan menambah fitur di luar dokumen itu. Jika tidak jelas, tanyakan dulu.
- Di luar lingkup: pembayaran, pengiriman, pemesanan online, registrasi pelanggan, aplikasi mobile.

## 2. Aktor
- Pelanggan: publik, tanpa login, hanya melihat informasi.
- Admin: login, mengelola menu (tambah, ubah, hapus), memperbarui foto dan harga.
- Owner (pemilik UMKM): login, melihat ringkasan dashboard, mengelola promosi, profil usaha, dan akun admin. Owner juga boleh mengelola menu.
- Admin dan Owner yang login tetap boleh membuka halaman publik.

## 3. Stack
- PHP, Laravel (MVC), MySQL, Blade, Tailwind CSS, Vite.
- Server lokal Laragon. Peta: Google Maps embed. Kontak: tautan https://wa.me/nomor.

## 4. Database (4 tabel)
- users: id, nama, email (unik), password, role (owner atau admin).
- menu: id, created_by (FK users), nama_menu, kategori, deskripsi, harga, foto, status (tersedia atau habis), is_unggulan.
- promosi: id, created_by (FK users), judul, deskripsi, banner, tanggal_mulai, tanggal_selesai, is_aktif.
- profil_usaha: id, updated_by (FK users), nama_usaha, deskripsi, alamat, latitude, longitude, no_whatsapp, instagram, jam_operasional, logo. Hanya satu baris.
- Semua FK memakai ON DELETE SET NULL. Semua tabel punya created_at dan updated_at.
- Tidak ada model Kategori. Kategori adalah konstanta di Menu.php: ['Mie','Minuman','Tambahan'].

## 5. Struktur dan penamaan
- Model: User, Menu, Promosi, ProfilUsaha (set $table untuk menu, promosi, profil_usaha).
- Controller publik di app/Http/Controllers: BerandaController, KatalogController, LokasiController, KontakController.
- Controller admin di app/Http/Controllers/Admin: LoginController, DashboardController, MenuController, PromosiController, ProfilUsahaController, AkunController.
- Form Request di app/Http/Requests: MenuRequest, PromosiRequest, ProfilUsahaRequest, AkunRequest.
- Middleware role di app/Http/Middleware.
- View: resources/views/layouts (app, admin), components, publik, admin.
- Nama kolom dan variabel memakai snake_case bahasa Indonesia.

## 6. Rute
- Publik: / (beranda), /menu (katalog), /menu/{menu} (detail), /lokasi, /kontak.
- Login: /admin/login. Semua rute /admin lain memakai middleware auth.
- Owner dan Admin: /admin/menu (resource).
- Hanya Owner: /admin (dashboard), /admin/promosi (resource), /admin/profil-usaha (edit dan update), /admin/akun (resource). Admin yang membuka rute ini mendapat 403.
- Tidak ada rute registrasi. Rute publik tidak boleh ditolak untuk pengguna yang sudah login.

## 7. Aturan fungsional
- Perubahan admin langsung tampil di halaman publik (data dari database yang sama).
- Hapus menu wajib dialog konfirmasi dan menghapus berkas fotonya.
- Promosi tampil di beranda hanya jika is_aktif benar dan hari ini berada dalam periodenya.
- Menu berstatus habis tetap tampil dengan penanda.
- Owner tidak boleh menghapus akunnya sendiri.

## 8. Keamanan
- Validasi dengan Form Request, pesan kesalahan bahasa Indonesia.
- CSRF aktif di semua form, keluaran Blade memakai {{ }}, tanpa SQL mentah dari input.
- Kata sandi di-hash. Batasi percobaan login (throttle).
- Unggahan foto: jpg, png, webp, maksimal 2 MB, nama berkas diacak, simpan di storage/app/public.
- Jangan menulis kata sandi atau data pribadi asli di kode atau prompt. Gunakan .env.

## 9. Antarmuka
- Mobile-first dan responsif. Tombol dan area sentuh minimal 44px.
- Palet: merah #B3281A, kuning #F2B84B, krem #FFF8EE, teks #2B1B10. Kontras teks minimal 4,5:1.
- Teks bahasa Indonesia. Gambar punya alt. Tiap halaman punya title dan meta description.
- Ikuti docs/mockup/. Data asli belum ada: pakai placeholder seperti [Nama menu] dan Rp [harga].
- Sidebar admin mengikuti role dan memuat tautan 'Lihat Website'.

## 10. Aturan kerja agen
- Kerjakan satu langkah per permintaan, lalu berhenti dan laporkan.
- Untuk tugas besar, buat rencana dulu dan tunggu persetujuan.
- Komentar kode bahasa Indonesia. Jelaskan tiap file yang dibuat dalam 1 sampai 2 kalimat.
- Minta konfirmasi sebelum menghapus file, mereset database, atau perintah destruktif.
- Setelah mengubah kode, jalankan dan uji. Perbaiki galat sebelum melapor selesai.
- Jangan menambah paket baru tanpa menyebut alasannya.

## 11. Pengujian
- Blackbox Testing untuk semua kebutuhan prioritas Must di PRD.
- Screenshot hasil uji disimpan di docs/hasil-uji/ (nama menyebut fitur).
- Bug dan perbaikannya dicatat di docs/catatan-pengujian.md.