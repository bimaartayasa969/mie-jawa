<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Form Request untuk validasi pembuatan dan pembaruan akun staf administrator.
 * Khusus diotorisasi untuk peran Owner, memvalidasi nama, keunikan email, dan kekuatan kata sandi.
 */
class AkunRequest extends FormRequest
{
    /**
     * Memastikan hanya peran Owner yang dapat mengelola akun pengguna.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isOwner();
    }

    /**
     * Aturan validasi pembuatan atau pembaruan akun.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isCreate = $this->isMethod('post');
        $akun = $this->route('akun');
        $akunId = $akun instanceof User ? $akun->id : $akun;

        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                $isCreate
                    ? 'unique:users,email'
                    : Rule::unique('users', 'email')->ignore($akunId),
            ],
            'password' => [
                $isCreate ? 'required' : 'nullable',
                'string',
                'min:8',
            ],
            'role' => ['nullable', 'string', Rule::in(['owner', 'admin'])],
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
            'nama.required' => 'Nama pengguna wajib diisi.',
            'nama.max' => 'Nama pengguna tidak boleh melebihi 255 karakter.',
            'email.required' => 'Alamat email pengguna wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email ini sudah terdaftar pada sistem.',
            'password.required' => 'Kata sandi wajib diisi untuk akun baru.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'role.in' => 'Peran pengguna harus berupa Admin atau Owner.',
        ];
    }
}

