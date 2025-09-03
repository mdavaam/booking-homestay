<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;

class PemesananController extends Controller
{
    public function create()
    {
    $user = Auth::user();
    $kamars = TipeKamar::all();
    $namaKamar = Kamar::all();

    return view('admin.admin-pemesanan-kamar', compact('kamars', 'namaKamar','user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama_pemesan' => 'required|string|max:255',
        'email' => 'required|email',
        'nohp' => 'nullable|string|max:20',
        'kebangsaan' => 'required|string|max:100',
        'id_kamar' => 'required|exists:nama_kamar,id',
        'check_in' => 'required|date',
        'check_out' => 'required|date|after_or_equal:check_in',
        'metode_pembayaran' => 'required|in:cash,midtrans',
        'total_harga' => 'required|numeric|min:1',
    ]);

    $user = Auth::user();
    $kamar = Kamar::findOrFail($request->id_kamar);

    $kode_transaksi = 'TRX-' . uniqid();

    $transaksi = Transaksi::create([
        'id_user' => $user->id,
        'id_kamar' => $kamar->id,
        'nama_pemesan' => $request->nama_pemesan,
        'kode_transaksi' => $kode_transaksi,
        'total_harga' => $request->total_harga,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'metode_pembayaran' => $request->metode_pembayaran,
        'status' => $request->metode_pembayaran === 'cash' ? 'success' : 'pending',
        'tanggal_transaksi' => now(),
        'tanggal_pembayaran' => $request->metode_pembayaran === 'cash' ? now() : null,
        'kebangsaan' => $request->kebangsaan,
        'kode_negara' => null,
        'nohp' => $request->nohp,
        'acceptedby' => $request->metode_pembayaran === 'cash' ? $user->name : null,
        'kadaluarsa' => now()->addMinutes(20),
    ]);

    $kamar->update(['status' => 'tidak tersedia']);

    if ($request->metode_pembayaran === 'midtrans') {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->kode_transaksi,
                'gross_amount' => $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $request->nama_pemesan,
                'email' => $request->email,
            ],
            'callbacks' => [
                'notification' => route('notification'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $transaksi->update(['snap_token' => $snapToken]);
            return view('admin.admin-pembayaran', [
                'snapToken' => $snapToken,
                'kode_transaksi' => $kode_transaksi,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat transaksi Midtrans: ' . $e->getMessage());
        }
    }

    return redirect()->route('admin.dashboard')->with('success', 'Transaksi cash berhasil ditambahkan.');
}



    public function pembayaran($kode_transaksi)
{
    $transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->firstOrFail();

    if (!$transaksi->snap_token) {
        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->kode_transaksi,
                'gross_amount' => $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $transaksi->nama_pemesan,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        $transaksi->update(['snap_token' => $snapToken]);
    } else {
        $snapToken = $transaksi->snap_token;
    }

    return view('admin.admin-pembayaran', compact('snapToken', 'transaksi'));
}
    public function statusTransaksi()
{
    $transaksi = Transaksi::with(['user', 'kamar'])
        ->where('status', 'pending')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('admin.admin-status-transaksi', compact('transaksi'));
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

public function laporan(Request $request)
{
    $transactions = Transaksi::query();

    if ($request->filled('daterange')) {
        $dates = preg_split('/( - | to )/', $request->input('daterange'));

        if (count($dates) === 2) {
            try {
                $startDate = Carbon::createFromFormat('d-m-Y', trim($dates[0]))->startOfDay();
                $endDate = Carbon::createFromFormat('d-m-Y', trim($dates[1]))->endOfDay();

                $transactions->whereBetween('created_at', [$startDate, $endDate]);
            } catch (\Exception $e) {
            }
        }
    } elseif ($request->filled('filter')) {
        $days = (int) $request->input('filter', 7);
        $transactions->where('created_at', '>=', now()->subDays($days));
    }

    $transactions = $transactions->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.admin-laporan-transaksi', compact('transactions'));
}

    public function print()
{
    $transaksi = Transaksi::with(['user', 'kamar', 'admin'])->get();
    $pdf = Pdf::loadView('admin.admin-print-laporan', compact('transaksi'));

    return $pdf->stream('laporan_pemesanan.pdf');
}

}