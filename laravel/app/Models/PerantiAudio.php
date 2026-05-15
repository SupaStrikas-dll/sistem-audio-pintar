<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerantiAudio extends Model
{
    protected $table = 'peranti_audio';

    protected $fillable = [
        'nama', 'jenama', 'id_kategori',
        'harga', 'penerangan', 'imej', 'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_peranti');
    }
}