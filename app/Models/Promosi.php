<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Promosi untuk mengelola banner dan penawaran diskon UMKM Mie Jawa.
 * Menyimpan data masa berlaku promo, banner visual, dan relasi ke user pembuat.
 */
class Promosi extends Model
{
    use HasFactory;

    /**
     * Nama tabel basis data.
     *
     * @var string
     */
    protected $table = 'promosi';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_by',
        'judul',
        'deskripsi',
        'banner',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_aktif',
    ];

    /**
     * Casting tipe data atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'is_aktif' => 'boolean',
        ];
    }

    /**
     * Relasi belongsTo ke User yang membuat promosi ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

