<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
{
   $search = trim((string) $request->input('search', ''));

        $kamarTersedia = Kamar::where('status', 'tersedia')->count();
        $totalOrder    = Transaksi::success()->count();

        $transactions = Transaksi::with('user')
            ->success()
            ->when($search !== '', fn($q) => $q->searchUserName($search))
            ->latest('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.dashboard.index', compact('transactions','kamarTersedia','totalOrder'));

    }

    public function laporan(Request $request)
{
    $transactions = transaksi::query();

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

}
