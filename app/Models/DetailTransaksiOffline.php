<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiOffline extends Model
{
    use HasFactory;

    protected $table = 'detailtransaksi_offline';
    protected $primaryKey = null; // Tidak ada primary key
    public $incrementing = false; // Menonaktifkan auto-increment
    public $timestamps = false;

    protected $fillable = [
        'idPenjualan',
        'idProduk',
        'jumlahBarang',
        'hargaTransaksi',
        'discountPerProduk',
        'sub',
    ];

    public function pemesananOffline()
    {
        return $this->belongsTo(PemesananOffline::class, 'idPenjualan', 'idPenjualan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }
}
