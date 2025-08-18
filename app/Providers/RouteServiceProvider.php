<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            // Route web default
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // Route user
            Route::middleware(['web', 'user'])
                ->prefix('')
                ->group(base_path('routes/user.php'));

            // Route admin
            Route::middleware(['web','auth', 'admin'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            // API routes
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }
}
