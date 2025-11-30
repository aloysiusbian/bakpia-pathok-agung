<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Keranjang extends Model
{
    use HasFactory;

    protected $table      = 'keranjang';
    protected $primaryKey = 'idKeranjang';

    public $incrementing = false;   // char(36)
    protected $keyType   = 'string';
    public $timestamps   = false;

    protected $fillable = [
        'idKeranjang',
        'idPelanggan',
        'idProduk',
        'subTotal',
        'jumlahBarang',
        'gambar',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->idKeranjang)) {
                $model->idKeranjang = (string) Str::uuid();
            }
        });
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }

    // ambil keranjang per pelanggan
    public static function getKeranjang($idPelanggan)
    {
        return static::with('produk')
            ->where('idPelanggan', $idPelanggan)
            ->get();
    }

    // tambah item ke keranjang
    public static function tambahKeKeranjang(array $data)
    {
        return static::create($data);
    }

    // hapus semua item keranjang milik pelanggan
    public static function hapusKeranjang($idPelanggan)
    {
        return static::where('idPelanggan', $idPelanggan)->delete();
    }

    // hapus satu item
    public static function hapusDariKeranjang($idKeranjang, $idPelanggan = null)
    {
        $query = static::where('idKeranjang', $idKeranjang);
        if ($idPelanggan !== null) {
            $query->where('idPelanggan', $idPelanggan);
        }
        return $query->delete();
    }
}
