<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeKamar extends Model
{
        use HasFactory;

    protected $table = 'tipe_kamar';

    protected $fillable = [
        'jenis_kamar',
        'harga_permalam',
        'deskripsi',
        'photo_kamar'
    ];
}
