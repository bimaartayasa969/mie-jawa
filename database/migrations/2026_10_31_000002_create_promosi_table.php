<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi untuk tabel promosi UMKM Mie Jawa.
 * Menyimpan judul, deskripsi promo, banner, rentang tanggal aktif, dan relasi pembuat (user).
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi tabel promosi.
     */
    public function up(): void
    {
        Schema::create('promosi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('banner')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi tabel promosi.
     */
    public function down(): void
    {
        Schema::dropIfExists('promosi');
    }
};

