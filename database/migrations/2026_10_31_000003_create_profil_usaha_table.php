<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi untuk tabel profil_usaha UMKM Mie Jawa (hanya satu baris data).
 * Menyimpan informasi profil warung, kontak WhatsApp, Instagram, jam buka, dan titik koordinat peta.
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi tabel profil_usaha.
     */
    public function up(): void
    {
        Schema::create('profil_usaha', function (Blueprint $table) {
            $table->id();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_usaha');
            $table->text('deskripsi')->nullable();
            $table->text('alamat')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('no_whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->text('jam_operasional')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi tabel profil_usaha.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_usaha');
    }
};

