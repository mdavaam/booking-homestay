<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipeKamar;
use Illuminate\Http\Request;

class JenisKamarController extends Controller
{
public function index() {
    $kamars = TipeKamar::all();
    return view('admin.admin-tipe-kamar', compact('kamars'));
}


public function store(Request $request)
{
    $request->validate([
        'jenis_kamar' => 'required|string',
        'deskripsi' => 'required|string',
        'harga_permalam' => 'required|integer',
        'photo_kamar' => 'required|image|max:2048',
    ]);

    $photoPath = null;

    if ($request->hasFile('photo_kamar')) {
        $photoPath = $request->file('photo_kamar')->store('kamar', 'public');
    }

    TipeKamar::create([
        'jenis_kamar' => $request->jenis_kamar,
        'deskripsi' => $request->deskripsi,
        'harga_permalam' => $request->harga_permalam,
        'photo_kamar' => $photoPath
    ]);

    return redirect()->back()->with('success', 'Kamar berhasil ditambahkan.');
}



    public function update(Request $request, $id) {
        $kamar = TipeKamar::findOrFail($id);

        $data = $request->validate([
            'jenis_kamar' => 'required',
            'harga_permalam' => 'required|integer',
            'deskripsi' => 'required',
        ]);

        if ($request->hasFile('photo_kamar')) {
            $data['photo_kamar'] = $request->file('photo_kamar')->store('kamars', 'public');
        }

        $kamar->update($data);


        return redirect()->route('admin.tipekamar')->with('success', 'Data berhasil diperbarui.');

    }

    public function destroy($id) {
        $kamar = TipeKamar::findOrFail($id);
        $kamar->delete();


        return redirect()->route('admin.tipekamar')->with('success', 'Data berhasil dihapus.');

    }

}

