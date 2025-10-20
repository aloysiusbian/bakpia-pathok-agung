<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'idProduk';
    public $timestamps = false;
    public $incrementing = false; // Karena idProduk adalah varchar

    protected $fillable = [
        'idProduk',
        'namaProduk',
        'deskripsiProduk',
        'pilihanJenis',
        'kategori',
        'rating',
        'harga',
        'stok',
        'gambar',
    ];

    public function detailTransaksiOffline()
    {
        return $this->hasMany(DetailTransaksiOffline::class, 'idProduk', 'idProduk');
    }

    public function detailTransaksiOnline()
    {
        return $this->hasMany(DetailTransaksiOnline::class, 'idProduk', 'idProduk');
    }
}
