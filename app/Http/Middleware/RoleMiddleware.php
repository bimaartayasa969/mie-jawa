<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk membatasi akses rute berdasarkan peran (role) pengguna.
 * Menolak pengguna yang tidak memiliki wewenang dengan status HTTP 403 Forbidden.
 */
class RoleMiddleware
{
    /**
     * Menangani permintaan masuk dan memeriksa peran pengguna aktif.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Pastikan pengguna telah login
        if (! $request->user()) {
            return redirect()->route('admin.login');
        }

        // Periksa apakah peran pengguna ada di dalam daftar peran yang diizinkan
        if (! in_array($request->user()->role, $roles, true)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang untuk membuka halaman ini.');
        }

        return $next($request);
    }
}

