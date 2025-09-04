<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
{
   $search = trim((string) $request->input('search', ''));

        $kamarTersedia = Kamar::where('status', 'tersedia')->count();
        $totalOrder    = Transaksi::where('status', 'success')->count();

        $transactions = Transaksi::with('user')
            ->where('status', 'success')
            ->when($search !== '', fn($q) => $q->searchUserName($search))
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.admin-dashboard', compact('transactions','kamarTersedia', 'totalOrder'));

    }

}