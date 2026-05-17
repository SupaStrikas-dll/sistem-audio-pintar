<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PilihanPengguna extends Model
{
    protected $table = 'pilihan_pengguna';

    protected $fillable = [
        'id_pengguna',
        'jenis',
        'bajet',
        'kegunaan',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function cadangan()
    {
        return $this->hasMany(Cadangan::class, 'id_pilihan');
    }
}