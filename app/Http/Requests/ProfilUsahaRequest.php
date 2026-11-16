<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request untuk validasi pembaruan profil usaha UMKM Mie Jawa.
 * Khusus diotorisasi untuk peran Owner, memvalidasi nomor kontak WhatsApp, koordinat peta, dan logo.
 */
class ProfilUsahaRequest extends FormRequest
{
    /**
     * Memastikan pengguna terautentikasi (Owner atau Admin) dapat memperbarui profil usaha.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Aturan validasi informasi profil usaha.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_usaha' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'alamat' => ['required', 'string', 'max:500'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'no_whatsapp' => ['required', 'string', 'max:25', 'regex:/^[0-9+\s\-()]+$/'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'jam_operasional' => ['nullable', 'string', 'max:500'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * Pesan kesalahan khusus bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_usaha.required' => 'Nama usaha warung wajib diisi.',
            'nama_usaha.max' => 'Nama usaha tidak boleh melebihi 255 karakter.',
            'alamat.required' => 'Alamat lengkap warung wajib diisi.',
            'alamat.max' => 'Alamat tidak boleh melebihi 500 karakter.',
            'latitude.numeric' => 'Nilai garis lintang (latitude) harus berupa angka desimal yang valid.',
            'latitude.between' => 'Nilai latitude harus berada dalam rentang -90 hingga 90.',
            'longitude.numeric' => 'Nilai garis bujur (longitude) harus berupa angka desimal yang valid.',
            'longitude.between' => 'Nilai longitude harus berada dalam rentang -180 hingga 180.',
            'no_whatsapp.required' => 'Nomor WhatsApp atau telepon pemesanan wajib diisi.',
            'no_whatsapp.regex' => 'Format nomor WhatsApp tidak valid. Gunakan format angka/internasional yang benar.',
            'logo.image' => 'Berkas logo harus berupa gambar valid.',
            'logo.mimes' => 'Format gambar logo harus berupa JPG, PNG, atau WebP.',
            'logo.max' => 'Ukuran berkas logo maksimal 2 MB.',
        ];
    }
}

