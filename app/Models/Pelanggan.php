<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'idPelanggan';
    public $timestamps = false;
    protected $fillable = [
        'password',
        'email',
        'alamat',
        'noTelp',
    ];
    public $incrementing = true; // Mengaktifkan auto-increment karena primary key adalah integer

    public function pemesananOnline()
    {
        return $this->hasMany(PemesananOnline::class, 'idPelanggan', 'idPelanggan');
    }
}
