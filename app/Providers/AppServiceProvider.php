<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa skema HTTPS di server produksi/cloud (Railway) agar aset CSS/JS tidak terblokir Mixed Content
        if ($this->app->environment('production') 
            || str_contains(request()->getHost(), 'railway.app') 
            || request()->header('x-forwarded-proto') === 'https'
            || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }

        // Binding parameter rute {akun} secara eksplisit ke model User
        Route::model('akun', User::class);
    }
}
