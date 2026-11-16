<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User untuk autentikasi dan otorisasi aktor (Owner dan Admin).
 * Menyimpan data pengguna, peran, serta relasi data menu, promosi, dan profil usaha.
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    /**
     * Atribut yang disembunyikan dalam serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi hasMany ke data Menu yang dibuat oleh pengguna ini.
     */
    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class, 'created_by');
    }

    /**
     * Relasi hasMany ke data Promosi yang dibuat oleh pengguna ini.
     */
    public function promosi(): HasMany
    {
        return $this->hasMany(Promosi::class, 'created_by');
    }

    /**
     * Relasi hasOne ke data ProfilUsaha yang terakhir diperbarui oleh pengguna ini.
     */
    public function profilUsaha(): HasOne
    {
        return $this->hasOne(ProfilUsaha::class, 'updated_by');
    }

    /**
     * Memeriksa apakah pengguna memiliki peran sebagai Owner (pemilik UMKM).
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Memeriksa apakah pengguna memiliki peran sebagai Admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
