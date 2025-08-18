<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\HalamanUserController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\RiwayatPemesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Middleware\User;

Route::middleware([User::class])->group(function () {
    Route::get('/home', [HalamanUserController::class, 'home'])->name('home');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateName'])->name('profile.update');
    Route::get('/my-booking', [RiwayatPemesananController::class, 'index'])->name('myBookings');
    Route::get('/order-success/{transaksi}', [RiwayatPemesananController::class, 'orderSuccess'])->name('order.success');
    Route::post('/transaksi/{kamarId}', [TransaksiController::class, 'show'])->name('transaksi');
    Route::post('/pembayaran', [PembayaranController::class, 'checkout'])->name('pembayaran');
    Route::get('/pembayaran/{kode_transaksi}', [PembayaranController::class, 'lanjutkanPembayaran'])->name('pembayaran.lanjut');
    Route::delete('/batalkan-pesanan/{transaksi}', [TransaksiController::class, 'batalkan'])->name('batalkan.pesanann');
});
