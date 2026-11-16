<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request untuk validasi kampanye promosi dan banner diskon.
 * Memastikan tanggal selesai tidak mendahului tanggal mulai dan membatasi ukuran berkas banner.
 */
class PromosiRequest extends FormRequest
{
    /**
     * Memastikan pengguna terautentikasi (Owner atau Admin) dapat mengelola promosi.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Menyiapkan data sebelum validasi.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_aktif' => $this->boolean('is_aktif'),
        ]);
    }

    /**
     * Aturan validasi promosi.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'is_aktif' => ['nullable', 'boolean'],
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
            'judul.required' => 'Judul promosi wajib diisi.',
            'judul.max' => 'Judul promosi tidak boleh melebihi 255 karakter.',
            'tanggal_mulai.required' => 'Tanggal mulai promosi wajib ditentukan.',
            'tanggal_selesai.required' => 'Tanggal selesai promosi wajib ditentukan.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai promosi tidak boleh lebih awal dari tanggal mulai.',
            'banner.image' => 'Berkas banner harus berupa file gambar.',
            'banner.mimes' => 'Format gambar banner harus berupa JPG, PNG, atau WebP.',
            'banner.max' => 'Ukuran berkas banner maksimal 2 MB.',
        ];
    }
}

