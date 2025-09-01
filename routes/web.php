<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleAuth\MediaSosialController;
use App\Http\Controllers\Booking\PemesananKamarController;
use App\Http\Controllers\User\HalamanUserController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

// ----------Public Routes----------
Route::get('/', [HalamanUserController::class, 'index'])
    ->middleware(RedirectIfAuthenticated::class)
    ->name('welcome');

//----------Guest Routes----------
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'store'])->name('register');
Route::get('/booking/{nomorKamar}', [PemesananKamarController::class, 'index'])->name('pesan.kamar');
Route::get('/kamar', [HalamanUserController::class, 'filter'])->name('filter.kamar');
Route::get('/detail-kamar', [HalamanUserController::class, 'namaKamar'])->name('detail.kamar');
Route::get('/redirect/google-login', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'home');
    }
    session(['google_action' => 'login']);
    return Socialite::driver('google')
        ->with(['prompt' => 'select_account'])
        ->redirect();
})->name('google.login.redirect');

Route::get('/redirect/google-register', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'home');
    }
    session(['google_action' => 'register']);
    return Socialite::driver('google')->redirect();
})->name('google.register.redirect');

Route::get('/redirect-after-login', function () {
    if (!Auth::check()) {
        return redirect()->route('welcome');
    }

    return Auth::user()->role === 'admin' ? redirect()->route('admin.dashboard') : redirect()->route('home');
})->name('redirect.after.login');
Route::get('/callback/google', [MediaSosialController::class, 'handleGoogleCallback']);

Route::fallback(function () {
    return response()->view('404', [], 404);
});

//----------Auth----------
Route::middleware('guest')->group(function () {
    Route::post('lupa-password', [PasswordResetController::class, 'kirimResetLinkEmail'])->name('password.email');

    Route::get('reset-password/{token}', [PasswordResetController::class, 'create'])->name('password.reset');

    Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});

//----------404 Routes----------
Route::get('/login', fn() => abort(404));

require __DIR__ . '/admin.php';
require __DIR__ . '/user.php';