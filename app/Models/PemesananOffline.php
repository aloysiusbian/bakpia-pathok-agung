<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananOffline extends Model
{
    use HasFactory;

    protected $table = 'pemesananoffline';
    protected $primaryKey = 'idPenjualan';
    public $timestamps = false;

    protected $fillable = [
        'idPenjualan',
        'namaPelanggan',
        'tanggalPemesanan',
        'totalNota',
        'metodePembayaran',
        'noTelpPelanggan',
        'sumberPesanan',    
        'catatan',          
        'alamatPengirim',
        'discountPerNota',
    ];

    public function detailTransaksiOffline()
    {
        return $this->hasMany(DetailTransaksiOffline::class, 'idPenjualan', 'idPenjualan');
    }
}
