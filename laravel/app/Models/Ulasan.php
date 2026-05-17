<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $fillable = [
        'id_pengguna',
        'id_peranti',
        'penilaian',
        'komen',
        'tarikh',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function peranti()
    {
        return $this->belongsTo(PerantiAudio::class, 'id_peranti');
    }
}