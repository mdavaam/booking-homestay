<?php

namespace App\Http\Controllers;

use App\Models\Kamar;

class PemesananKamarController extends Controller
{
public function index($nama_kamar)
{
    session(['nama_kamar' => $nama_kamar]);

    $kamars = Kamar::with('photoKamar')
                ->where('nama_kamar', $nama_kamar)
                ->get();

    return view('user.pesan-kamar', compact('kamars', 'nama_kamar'));
}


}
