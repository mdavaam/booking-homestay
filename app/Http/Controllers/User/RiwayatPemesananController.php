<?php

namespace App\Http\Controllers\User;

use App\Models\Transaksi;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class RiwayatPemesananController extends Controller
{
    public function index()
    {
        Transaksi::where('id_user', auth()->id())
            ->whereIn('status', ['pending', 'success'])
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $pesananku = Transaksi::with('kamar')
            ->where('id_user', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.riwayat-pemesanan', compact('pesananku'));
    }

    public function orderSuccess($kode)
    {
        $transaksi = Transaksi::where('kode_transaksi', $kode)->firstOrFail();

        $checkin = Carbon::parse($transaksi->check_in);
        $checkout = Carbon::parse($transaksi->check_out);
        $durasi = $checkin->diffInDays($checkout);

        return view('user.pesanan-sukses', compact('transaksi', 'durasi'));
    }
}
