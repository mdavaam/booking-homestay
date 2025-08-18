<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/notification', [PembayaranController::class, 'notification'])->name('notification');
