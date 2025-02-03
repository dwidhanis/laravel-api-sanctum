<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
    // Menyimpan rute default ke halaman beranda aplikasi setelah pengguna berhasil login
     public const HOME = '/home';
     
    // boot digunakan untuk mengatur perilaku aplikasi saat proses bootstrapping (inisialisasi)
    public function boot(): void
    {
        /*
        Mengatur pembatasan laju untuk API. Batasan ini akan membatasi jumlah permintaan API 
        menjadi 60 permintaan per menit per pengguna atau per alamat IP. Jika pengguna terautentikasi,
        pembatasan akan diterapkan berdasarkan ID pengguna, jika tidak, pembatasan akan diterapkan 
        berdasarkan alamat IP.
        */

        app(RateLimiter::class)->for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        /*
        Mengelompokkan semua rute yang ada di routes/api.php dengan middleware api dan menambahkan
        prefix api pada setiap rute. Ini berarti semua rute dalam file api.php akan diakses dengan
        URL yang diawali dengan /api.
        */
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        /*
        Mengelompokkan semua rute yang ada di routes/web.php dengan middleware web. Middleware web
        biasanya mencakup middleware yang menangani sesi, autentikasi, CSRF (Cross-Site Request
        Forgery) protection, dan lainnya yang relevan untuk aplikasi web.
        */
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
