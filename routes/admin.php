<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\JenisKamarController;
use App\Http\Controllers\Admin\PemesananController;
use App\Http\Middleware\Admin;

Route::middleware([Admin::class])->group(function (): void {
    Route::get('/admin-dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin-order', [OrdersController::class, 'index'])->name('admin.order');
    Route::post('/admin-orders/{id}/accept', [OrdersController::class, 'accept'])->name('orders.accept');
    Route::get('/admin-tipekamar', [JenisKamarController::class, 'index'])->name('admin.tipekamar');
    Route::post('/admin-tipekamar', [JenisKamarController::class, 'store'])->name('admin.jeniskamar');
    Route::put('/admin-tipekamar/update/{id}', [JenisKamarController::class, 'update'])->name('admin.update');
    Route::delete('/admin-tipekamar/delete/{id}', [JenisKamarController::class, 'destroy'])->name('admin.kamardepan.destroy');
    Route::get('/admin-kamar', [KamarController::class, 'index'])->name('admin.kamardalam');
    Route::post('/admin-kamar/simpanKamar', [KamarController::class, 'store'])->name('admin.kamardalamStore');
    Route::post('/admin-kamar/addPhoto/{nama_kamar}', [KamarController::class, 'addPhoto'])->name('admin.addPhoto');
    Route::put('/admin-kamar/update/{id}', [KamarController::class, 'update'])->name('admin.kamar.update');
    Route::delete('/admin-kamar/delete/{id}', [KamarController::class, 'destroy'])->name('admin.kamardalam.destroy');
    Route::get('/admin-detail-transaksi/{id}/detail', [OrdersController::class, 'detail'])->name('detail.transaksi');
    Route::get('/laporan-transaksi', [DashboardController::class, 'laporan'])->name('laporan.transaksi');
    Route::get('/admin-pemesanan', [PemesananController::class, 'create'])->name('admin.pemesanan');
    Route::post('/admin-transaksi-store', [PemesananController::class, 'store'])->name('admin.transaksi.store');
    Route::get('/admin-pembayaran/{kode_transaksi}', [PemesananController::class, 'pembayaran'])->name('admin.pembayaran');
    Route::get('/transaksi', [PemesananController::class, 'statusTransaksi'])->name('status.transaksi');
    Route::get('/admin-pembayaran/{kode_transaksi}', [PemesananController::class, 'pembayaran'])->name('pembayaran.lanjutan');
    Route::delete('/batalkan-pemesanan/{id}', [PemesananController::class, 'batalkan'])->name('batalkan-pesanan');
    Route::get('/print-pdf', [PemesananController::class, 'print'])->name('printpdf');
});