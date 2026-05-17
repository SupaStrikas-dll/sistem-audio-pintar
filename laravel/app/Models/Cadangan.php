<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadangan extends Model
{
    protected $table = 'cadangan';

    protected $fillable = [
        'id_pilihan',
        'id_peranti',
        'skor_padanan',
    ];

    public function pilihan()
    {
        return $this->belongsTo(PilihanPengguna::class, 'id_pilihan');
    }

    public function peranti()
    {
        return $this->belongsTo(PerantiAudio::class, 'id_peranti');
    }
}