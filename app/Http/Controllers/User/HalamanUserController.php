<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HalamanUserController extends Controller
{
    public function index()
    {
        $kamars = TipeKamar::all();

        return response()->view('welcome', compact('kamars'))->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')->header('Pragma', 'no-cache')->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }

    public function home()
    {
        $kamars = TipeKamar::all();
        return view('user.home-user', compact('kamars'));
    }
    public function namaKamar(Request $request)
    {
        $tipe = $request->jenis_kamar;

        if ($tipe) {
            $kamars = Kamar::where('jenis_kamar', $tipe)->get();
        } else {
            $kamars = Kamar::all();
        }

        return view('user.detail-kamar', compact('kamars', 'tipe'));
    }

    public function filter(Request $request)
    {
        $checkin = Carbon::parse($request->checkin)->format('Y-m-d');
        $checkout = Carbon::parse($request->checkout)->format('Y-m-d');

        $tipeKamars = Kamar::select('jenis_kamar')->distinct()->get();
        $kamarsByTipe = [];

        foreach ($tipeKamars as $tipe) {
            $kamars = Kamar::where('jenis_kamar', $tipe->jenis_kamar)
                ->whereDoesntHave('filter', function ($query) use ($checkin, $checkout) {
                    $query->where(function ($q) use ($checkin, $checkout) {
                        $q->where('check_in', '<', $checkout)->where('check_out', '>', $checkin);
                    });
                })
                ->get();

            $kamarsByTipe[$tipe->jenis_kamar] = $kamars;
        }

        return view('user.kamar-filter', compact('kamarsByTipe', 'checkin', 'checkout'));
    }
}
