<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use App\Models\kamar;
use Carbon\Carbon;
use Laravel\Scheduling\Attributes\AsScheduled;

#[AsScheduled('* * * * *')] // Setiap menit
class AutoUpdateStatusKamar extends Command
{
    protected $signature = 'kamar:update-status-checkout';
    protected $description = 'Update status kamar menjadi tersedia setelah tamu checkout';

    public function handle()
    {
        $today = Carbon::today();

        $transaksis = transaksi::where('status', 'success')
            ->whereDate('check_out', $today)
            ->get();

        foreach ($transaksis as $transaksi) {
            $kamar = kamar::find($transaksi->id_kamar);

            if ($kamar && $kamar->status !== 'tersedia') {
                $kamar->update(['status' => 'tersedia']);
                $this->info("Kamar ID {$kamar->id} diubah menjadi tersedia.");
            }
        }

        return Command::SUCCESS;
    }
}