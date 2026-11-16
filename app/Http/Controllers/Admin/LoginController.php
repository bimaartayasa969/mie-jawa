<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Controller untuk mengelola proses autentikasi (login dan logout) akun staf UMKM Mie Jawa.
 * Menyediakan pembatasan percobaan login (throttling) dan pengalihan dinamis berdasarkan peran.
 */
class LoginController extends Controller
{
    /**
     * Menampilkan form login dasbor pengelolaan.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        // Jika sudah login, langsung alihkan ke dasbor pengelolaan
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Memproses percobaan login dari form autentikasi.
     *
     * @throws ValidationException
     */
    public function login(Request $request): RedirectResponse
    {
        // Validasi input form dengan pesan kesalahan bahasa Indonesia
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        // Periksa apakah pengguna melebihi batas percobaan login (throttle)
        $this->ensureIsNotRateLimited($request);

        $remember = $request->boolean('remember');

        // Upaya autentikasi pengguna
        if (! Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey($request), 60);

            throw ValidationException::withMessages([
                'email' => 'Kombinasi email dan kata sandi tidak cocok dengan data kami.',
            ]);
        }

        // Hapus jejak pembatasan throttle setelah login berhasil
        RateLimiter::clear($this->throttleKey($request));
        $request->session()->regenerate();

        // Pengalihan tujuan ke dasbor pengelolaan
        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Memproses pengeluaran sesi pengguna (logout).
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('status', 'Anda telah berhasil keluar dari sistem.');
    }

    /**
     * Menghasilkan kunci unik untuk pelacakan pembatasan percobaan login (throttle).
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
    }

    /**
     * Memastikan percobaan login tidak melebihi batas maksimal (5 kali percobaan).
     *
     * @throws ValidationException
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        $throttleKey = $this->throttleKey($request);

        if (! RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($throttleKey);

        throw ValidationException::withMessages([
            'email' => "Terlalu banyak percobaan masuk yang gagal. Silakan coba lagi dalam {$seconds} detik.",
        ]);
    }
}

