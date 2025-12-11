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

     //  1) Status stok habis atau tidak
    public function getIsOutOfStockAttribute(): bool
    {
        return (int) $this->stok <= 0;
    }

    // 2) Gambar yang ditampilkan (otomatis pilih)
    public function getDisplayImageAttribute(): string
    {

        // kalau stok masih ada -> tampilkan gambar produk dari storage
        // (kalau gambar produk kamu bukan di storage, lihat catatan di bawah)
        return $this->gambar
        
    ? asset('images/' . $this->gambar)
    : asset('images/default.png');
    }

        public function getTotalTerjualAttribute(): int
    {
        
        $offline = $this->detailTransaksiOffline->sum('jumlahBarang');
        $online  = $this->detailTransaksiOnline->sum('jumlahBarang');

        return $offline + $online;
    }


    public function detailTransaksiOffline()
    {
        return $this->hasMany(DetailTransaksiOffline::class, 'idProduk', 'idProduk');
    }

    public function detailTransaksiOnline()
    {
        return $this->hasMany(DetailTransaksiOnline::class, 'idProduk', 'idProduk');
    }
}
