<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoKamar extends Model
{
    protected $table = 'foto_kamar';

    protected $fillable = [
        'kamar_id',
        'photo_path',
    ];

}

class foto extends Model
{
    public function kamarDalam()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id');
    }
}