<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiOnline extends Model
{
    use HasFactory;

    protected $table = 'detailtransaksi_online';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'nomorPemesanan',
        'idProduk',
        'jumlahBarang',
        'harga',
        'discountPerProduk',
        'subTotal',
    ];

    public function pemesananOnline()
    {
        return $this->belongsTo(PemesananOnline::class, 'nomorPemesanan', 'nomorPesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }
}
