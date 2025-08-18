<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{

    public function index()
    {
        $orders = Transaksi::with(['user', 'admin', 'kamar'])
            ->where('status', 'success')
            ->latest()
            ->get();

        return view('admin.admin-order', compact('orders'));
    }

    public function accept($id)
    {
        $order = Transaksi::findOrFail($id);
        $order->acceptedby = Auth::id();
        $order->save();

        return redirect()->back()->with('success', 'Order berhasil diterima.');
    }
    public function detail($id)
    {
        $transaksi = Transaksi::with(['user', 'kamar'])->findOrFail($id);

        return view('admin.admin-detail-transaksi', compact('transaksi'));
    }
}
