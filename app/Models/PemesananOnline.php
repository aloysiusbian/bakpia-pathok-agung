<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PemesananOnline extends Model
{
    use HasFactory;

    protected $table      = 'pemesananonline';
    protected $primaryKey = 'nomorPemesanan';

    public $incrementing = false;   // char(36) UUID
    protected $keyType   = 'string';
    public $timestamps   = false;

    protected $fillable = [
        'nomorPemesanan',
        'idPelanggan',
        'tanggalPemesanan',
        'totalNota',
        'metodePembayaran',
        'statusPesanan',
        'discountPerNota',
        'alamatPengirim',
        'buktiPembayaran',
        'catatan',
    ];

    public const STATUS_PO = 'menunggu_pembayaran';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->nomorPemesanan)) {
                $model->nomorPemesanan = (string) Str::uuid();
            }
        });
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idPelanggan', 'idPelanggan');
    }

    public function detailTransaksiOnline()
    {
        return $this->hasMany(
            DetailTransaksiOnline::class,
            'nomorPemesanan',
            'nomorPemesanan'
        );
    }
    
}
