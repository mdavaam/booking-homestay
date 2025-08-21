<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
    if (Auth::check()) {
        $notifikasi = transaksi::where('id_user', auth()->id())
            ->whereIn('status', ['pending', 'success'])
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();

        $view->with('notifikasiUser', $notifikasi);
    }
});



        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }
}