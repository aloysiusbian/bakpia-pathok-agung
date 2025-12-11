<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pelanggan';
    protected $primaryKey = 'idPelanggan';
    public $timestamps = false;
    protected $fillable = [
        'username',
        'password',
        'email',
        'noTelp',
        'image',
    ];
    public $incrementing = true; // Mengaktifkan auto-increment karena primary key adalah integerr

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function pemesananOnline()
    {
        return $this->hasMany(PemesananOnline::class, 'idPelanggan', 'idPelanggan');
    }


}
