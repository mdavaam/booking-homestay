<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FotoKamar;
use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{

    public function index()
{
    $kamars = Kamar::all();
    $tipekamar = TipeKamar::pluck('jenis_kamar');
    $kamarDalam = Kamar::all();


    return view('admin.admin-kamar', compact('kamars', 'tipekamar','kamarDalam'));
}


    public function store(Request $request)
{
    $request->validate([
        'jenis_kamar' => 'required|exists:tipe_kamar,jenis_kamar',
        'nama_kamar' => 'required|string',
        'deskripsi' => 'required|string',
        'status' => 'nullable|string',
        'harga_permalam' => 'required|integer',
        'photo_utama' => 'required|image|max:2048', // Satu file, bukan array
    ]);

    // Proses upload foto
    $photoPath = null;
    if ($request->hasFile('photo_utama')) {
        $pathUtama = $request->file('photo_utama')->store('nama_kamar', 'public');
    }

    $kamar = Kamar::create([
        'jenis_kamar'    => $request->jenis_kamar,
        'nama_kamar'    => $request->nama_kamar,
        'deskripsi'     => $request->deskripsi,
        'status'        => $request->status ?? 'tersedia',
        'harga_permalam' => $request->harga_permalam,
        'photo_utama'    => $pathUtama,
    ]);

    return redirect()->back()->with('success', 'Kamar dalam berhasil ditambahkan.');
}

public function kamarDalam($jenisKamar)
{
    $kamars = Kamar::where('jenisKamar', $jenisKamar)
                ->get();

    return view('user.detail-kamar', compact('kamars', 'jenisKamar'));
}

    public function detailKamar()
    {
        $kamars = Kamar::all();
        return view('user.detail-kamar', compact('kamars'));
    }

public function addPhoto(Request $request, $nama_kamar)
{
    $request->validate([
        'photo_kamar' => 'required',
        'photo_kamar.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $kamar = Kamar::where('nama_kamar', $nama_kamar)->firstOrFail();

    if ($request->hasFile('photo_kamar')) {
        foreach ($request->file('photo_kamar') as $file) {
            $path = $file->store('rooms', 'public');

            FotoKamar::create([
                'kamar_id' => $kamar->id,
                'photo_path' => $path,
            ]);
        }
    }

    return back()->with('success', 'Foto kamar berhasil diupload.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'jenis_kamar' => 'required',
        'nama_kamar' => 'required',
        'harga_permalam' => 'required|numeric|min:0',
        'deskripsi' => 'required',
        'status' => 'required|in:tersedia,tidak tersedia',
    ]);

    $kamar = Kamar::findOrFail($id);

    $kamar->update([
        'jenis_kamar' => $request->jenis_kamar,
        'nama_kamar' => $request->nama_kamar,
        'harga_permalam' => $request->harga_permalam,
        'deskripsi' => $request->deskripsi,
        'status' => $request->status,
    ]);

    return redirect()->back()->with('success', 'Kamar berhasil di update.');
}


    public function destroy($id)
{
    $kamar = Kamar::findOrFail($id);
    $kamar->delete();

    return redirect()->back()->with('success', 'Kamar berhasil dihapus.');
}

}
