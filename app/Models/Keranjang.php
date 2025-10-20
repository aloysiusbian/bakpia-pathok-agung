<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'nomorPemesanan';
    public $timestamps = false;
    protected $fillable = [
        'idProduk',
        'totalNota',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }

    /**
     * Definisikan relasi: setiap item keranjang dimiliki oleh satu User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'idPelanggan');
    }
}
