<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migrasi untuk tabel menu hidangan UMKM Mie Jawa.
 * Menyimpan data sajian, kategori, harga, status ketersediaan, dan relasi pembuat (user).
 */
return new class extends Migration
{
    /**
     * Jalankan migrasi tabel menu.
     */
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nama_menu');
            $table->string('kategori');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('harga');
            $table->string('foto')->nullable();
            $table->enum('status', ['tersedia', 'habis'])->default('tersedia');
            $table->boolean('is_unggulan')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi tabel menu.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};

