<?php

namespace App\Http\Requests;

use App\Models\Menu;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Form Request untuk validasi data penambahan dan pembaruan menu hidangan.
 * Menerapkan batasan format gambar, ukuran maksimal 2 MB, dan pesan kesalahan bahasa Indonesia.
 */
class MenuRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna memiliki wewenang untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Mempersiapkan input sebelum validasi dijalankan.
     */
    protected function prepareForValidation(): void
    {
        // 1. Tangani penentuan status ketersediaan bahan menu ('tersedia' atau 'habis')
        if ($this->filled('status')) {
            $status = $this->input('status');
        } elseif ($this->has('status_tersedia')) {
            $status = $this->boolean('status_tersedia') ? 'tersedia' : 'habis';
        } elseif ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            // Pada formulir edit, jika status tidak terkirim (misal checkbox tidak dicentang), berarti habis
            $status = 'habis';
        } else {
            // Nilai baku saat tambah hidangan baru
            $status = 'tersedia';
        }

        $this->merge([
            'status' => $status,
            'is_unggulan' => $this->boolean('is_unggulan'),
        ]);
    }

    /**
     * Aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_menu' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'string', Rule::in(Menu::KATEGORI)],
            'harga' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', 'string', Rule::in(['tersedia', 'habis'])],
            'is_unggulan' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Pesan kesalahan khusus berbahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_menu.required' => 'Nama menu hidangan wajib diisi.',
            'nama_menu.max' => 'Nama menu hidangan tidak boleh melebihi 255 karakter.',
            'kategori.required' => 'Kategori menu hidangan wajib dipilih.',
            'kategori.in' => 'Kategori yang dipilih tidak valid. Pilihan: ' . implode(', ', Menu::KATEGORI) . '.',
            'harga.required' => 'Harga hidangan wajib diisi.',
            'harga.integer' => 'Harga hidangan harus berupa angka bulat.',
            'harga.min' => 'Harga hidangan tidak boleh bernilai negatif.',
            'deskripsi.max' => 'Deskripsi hidangan tidak boleh melebihi 1000 karakter.',
            'foto.image' => 'Berkas yang diunggah harus berupa file gambar.',
            'foto.mimes' => 'Format foto harus berupa JPG, PNG, atau WebP.',
            'foto.max' => 'Ukuran berkas foto tidak boleh melebihi 2 MB.',
            'status.required' => 'Status ketersediaan hidangan wajib ditentukan.',
            'status.in' => 'Status ketersediaan hidangan harus berupa tersedia atau habis.',
        ];
    }
}

