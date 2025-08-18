<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'nama_kamar';

    protected $fillable = [
        'jenis_kamar',
        'nama_kamar',
        'deskripsi',
        'photo_utama',
        'status',
        'harga_permalam',
    ];

public function photoKamar()
{
    return $this->hasMany(FotoKamar::class, 'kamar_id');
}
public function filter()
{
    return $this->hasMany(transaksi::class, 'id_kamar');
}


}





