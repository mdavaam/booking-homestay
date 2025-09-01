<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransaksiController extends Controller
{

    public function show($kamarId, Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $kamar = Kamar::findOrFail($kamarId);

        $check_in = $request->input('check_in');
        $check_out = $request->input('check_out');
        $checkInDate = Carbon::parse($check_in);
        $checkOutDate = Carbon::parse($check_out);

    $diffDays = $checkInDate->diffInDays($checkOutDate);
    $harga_permalam = abs($kamar->harga_permalam);
    $total_harga = $diffDays * $harga_permalam;


        return view('user.user-transaksi', compact('kamar', 'check_in', 'check_out', 'total_harga'));

}
public function batalkan($id)
{
    $transaksi = Transaksi::findOrFail($id);

    if ($transaksi->status !== 'pending') {
        return redirect()->back()->with('error', 'Hanya pesanan pending yang dapat dibatalkan.');
    }

    if ($transaksi->kamar) {
        $transaksi->kamar->update(['status' => 'tersedia']);
    }

    $transaksi->delete();
    return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
}


}
?>
