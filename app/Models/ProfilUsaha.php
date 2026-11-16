<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model ProfilUsaha untuk informasi resmi UMKM Mie Jawa (entitas baris tunggal).
 * Menyimpan nama warung, alamat lengkap, kontak WhatsApp, jam operasional, dan relasi pengubah terakhir.
 */
class ProfilUsaha extends Model
{
    use HasFactory;

    /**
     * Nama tabel basis data.
     *
     * @var string
     */
    protected $table = 'profil_usaha';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'updated_by',
        'nama_usaha',
        'deskripsi',
        'alamat',
        'latitude',
        'longitude',
        'no_whatsapp',
        'instagram',
        'jam_operasional',
        'logo',
    ];

    /**
     * Casting tipe data atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    /**
     * Relasi belongsTo ke User yang terakhir memperbarui profil usaha ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

