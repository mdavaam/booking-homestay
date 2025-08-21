<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use App\Models\kamar;
use App\Services\BrevoMailService;



class BatalkanPesananExpired extends Command
{
    protected $signature = 'pesanan:batalkan-expired';
    protected $description = 'Batalkan pesanan yang pending dan melewati batas waktu 15 menit';

    public function handle()
{
    $expiredTransactions = transaksi::where('status', 'pending')
        ->where('kadaluarsa', '<', now())
        ->get();

    foreach ($expiredTransactions as $transaksi) {
        $transaksi->update(['status' => 'expired']);

        $kamar = kamar::find($transaksi->id_kamar);
        if ($kamar) {
            $kamar->update(['status' => 'tersedia']);
        }

        try {
            $emailService = new BrevoMailService();
            $subject = 'Transaksi Anda Gagal';
            $html = view('email.notifikasi-transaksi', ['transaksi' => $transaksi])->render();
            $emailService->send($transaksi->user->email, $subject, $html);
            \Log::info('Notifikasi gagal dikirim ke: ' . $transaksi->user->email);
        } catch (\Exception $e) {
            \Log::error('Gagal kirim email expired: ' . $e->getMessage());
        }

        \Log::info("Transaksi {$transaksi->id} kadaluarsa dan dibatalkan.");
    }

    return Command::SUCCESS;
}

}