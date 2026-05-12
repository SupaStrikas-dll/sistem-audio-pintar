<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'emel',
        'kata_laluan',
        'peranan',
    ];

    protected $hidden = [
        'kata_laluan',
        'remember_token',
    ];

    // Beritahu Laravel guna 'kata_laluan' sebagai password
    public function getAuthPassword()
    {
        return $this->kata_laluan;
    }
}