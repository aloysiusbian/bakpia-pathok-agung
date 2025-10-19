<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananOnline extends Model
{
    use HasFactory;

    protected $table = 'pemesananonline';
    protected $primaryKey = 'nomorPesanan';
    public $timestamps = false;

    protected $fillable = [
        'idPelanggan',
        'tanggalPemesanan',
        'totalNota',
        'metodePembayaran',
        'statusPesanan',
        'discountPerNota',
        'alamatPengirim',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idPelanggan', 'idPelanggan');
    }

    public function detailTransaksiOnline()
    {
        return $this->hasMany(DetailTransaksiOnline::class, 'nomorPemesanan', 'nomorPesanan');
    }
}
