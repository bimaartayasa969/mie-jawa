<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Menu untuk katalog sajian hidangan UMKM Mie Jawa.
 * Menyediakan konstanta kategori pilihan, atribut sajian, dan relasi ke pembuat menu.
 */
class Menu extends Model
{
    use HasFactory;

    /**
     * Nama tabel basis data.
     *
     * @var string
     */
    protected $table = 'menu';

    /**
     * Konstanta kategori hidangan resmi UMKM Mie Jawa.
     */
    public const KATEGORI = ['Mie', 'Minuman', 'Tambahan'];

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_by',
        'nama_menu',
        'kategori',
        'deskripsi',
        'harga',
        'foto',
        'status',
        'is_unggulan',
    ];

    /**
     * Casting tipe data atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'is_unggulan' => 'boolean',
        ];
    }

    /**
     * Relasi belongsTo ke User yang menambahkan hidangan ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

