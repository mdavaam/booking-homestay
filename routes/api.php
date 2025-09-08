<?php

use App\Http\Controllers\Booking\PembayaranController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/notification', [PembayaranController::class, 'notification'])->name('notification');