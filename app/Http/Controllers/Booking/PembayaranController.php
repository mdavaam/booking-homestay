<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use App\Services\BrevoMailService;




class PembayaranController extends Controller
{
    public function checkout(Request $request)
    {
        \Log::info('Checkout Request:', $request->all());

        try {
            $request->validate([
                'kamar_id' => 'required|exists:nama_kamar,id',
                'check_in' => 'required|date',
                'check_out' => 'required|date|after:check_in',
                'kebangsaan' => 'required|string|max:100',
                'nohp' => $request->skip_kode_negara ? 'nullable' : 'required|string|max:20',
                'kode_negara' => $request->skip_kode_negara ? 'nullable' : 'required|string|max:10',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error:', $e->errors());
            throw $e;
        }

        $user = Auth::user();
        $kamar = Kamar::findOrFail($request->kamar_id);

        $diff = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));
        $total_harga = $diff * $kamar->harga_permalam;

        $transaksi = Transaksi::where('id_user', $user->id)
            ->where('id_kamar', $kamar->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if ($transaksi) {
            $transaksi->update([
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'total_harga' => $total_harga,
                'tanggal_transaksi' => now(),
                'kadaluarsa' => now()->addMinutes(5),

            ]);

        $kamar->update(['status' => 'tidak tersedia']);

} else {
    $kode_transaksi = 'TRX-' . uniqid();

    $transaksi = Transaksi::create([
        'id_user' => $user->id,
        'id_kamar' => $kamar->id,
        'nama_pemesan' => $user->name,
        'kode_transaksi' => $kode_transaksi,
        'total_harga' => $total_harga,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'metode_pembayaran' => 'midtrans',
        'status' => 'pending',
        'tanggal_transaksi' => now(),
        'tanggal_pembayaran' => null,
        'kebangsaan' => $request->kebangsaan,
        'kode_negara' => $request->skip_kode_negara ? null : $request->kode_negara,
        'nohp' => $request->skip_kode_negara ? null : $request->nohp,
        'acceptedby' => null,
        'kadaluarsa' => now()->addMinutes(5),
    ]);

    $kamar->update(['status' => 'tidak tersedia']);
}

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->kode_transaksi,
                'gross_amount' => $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $user->name,
            ],
            'callbacks' => [
                'notification' => route('notification'),
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaksi->update(['snap_token' => $snapToken]);
            \Log::info('Snap Token:', ['token' => $snapToken]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage());
        }
        try {
    $emailService = new BrevoMailService();
    $subject = 'Pemesanan Anda sedang diproses';
    $html = view('email.notifikasi-transaksi', ['transaksi' => $transaksi])->render();
    $emailService->send($user->email, $subject, $html);
    \Log::info('Email berhasil dikirim ke: ' . $user->email);
} catch (\Exception $e) {
    \Log::error('Gagal kirim email (checkout): ' . $e->getMessage());
}


        return view('user.pembayaran', [
            'snapToken' => $snapToken,
            'kode_transaksi' => $transaksi->kode_transaksi
        ]);
    }

public function notification(Request $request)
{
    $serverKey = config('midtrans.server_key');
    $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

    if ($hashed === $request->signature_key) {
        $transaksi = Transaksi::where('kode_transaksi', $request->order_id)->first();

        if ($transaksi) {
            $kamar = Kamar::find($transaksi->id_kamar);
            $status = $request->transaction_status;
            $emailService = new BrevoMailService();
            $to = $transaksi->user->email;

            try {
                if ($status === 'capture' || $status === 'settlement') {
                    $transaksi->update([
                        'status' => 'success',
                        'tanggal_pembayaran' => now(),
                        'metode_pembayaran' => $request->payment_type,
                    ]);

                    if ($kamar) {
                        $kamar->update(['status' => 'tidak tersedia']);
                    }

                    $subject = 'Pembayaran Berhasil';
                    $html = view('email.notifikasi-transaksi', ['transaksi' => $transaksi])->render();
                    $emailService->send($to, $subject, $html);

                } elseif ($status === 'pending') {
                    $transaksi->update(['status' => 'pending']);

                    $subject = 'Menunggu Pembayaran';
                    $html = view('email.notifikasi-transaksi', ['transaksi' => $transaksi])->render();
                    $emailService->send($to, $subject, $html);

                } elseif (in_array($status, ['failed', 'expired', 'cancel'])) {
                    $transaksi->update(['status' => 'expired']);

                    if ($kamar) {
                        $kamar->update(['status' => 'tersedia']);
                    }

                    $subject = 'Transaksi Gagal';
                    $html = view('email.notifikasi-transaksi', ['transaksi' => $transaksi])->render();
                    $emailService->send($to, $subject, $html);
                }

            } catch (\Exception $e) {
                \Log::error('Gagal kirim email (notification): ' . $e->getMessage());
            }
        }
    }

    return response('OK', 200);
}



public function lanjutkanPembayaran($kodetransaksi)
{
    $kodeTransaksiFull = 'TRX-' . $kodetransaksi;

    $transaksi = Transaksi::where('kode_transaksi', $kodeTransaksiFull)->first();

    if (!$transaksi || $transaksi->status !== 'pending') {
        return redirect()->route('myBookings')->with('error', 'Transaksi tidak valid atau sudah diproses.');
    }

    if (!$transaksi->snap_token) {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->kode_transaksi,
                'gross_amount' => $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $transaksi->user->name,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $transaksi->update(['snap_token' => $snapToken]);
    }

    return view('user.pembayaran', [
        'snapToken' => $transaksi->snap_token,
        'kode_transaksi' => $transaksi->kode_transaksi
    ]);
}

}
