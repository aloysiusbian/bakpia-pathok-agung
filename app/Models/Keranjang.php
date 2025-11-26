<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'idKeranjang';
    public $timestamps = false;
    protected $fillable = [
        'idPelanggan',
        'idProduk',
        'subTotal',
        'jumlahBarang',
        'gambar'
    ];

    // --- RELASI (WAJIB DITAMBAHKAN) ---

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idProduk', 'idProduk');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idPelanggan', 'idPelanggan');
    }

    // --- METHOD STATIC ---

    public static function tambahKeKeranjang($data)
    {
        $existing = static::where('idProduk', $data['idProduk'])
                          ->where('idPelanggan', $data['idPelanggan'])
                          ->first();

        if ($existing) {
            $existing->jumlahBarang += $data['jumlahBarang'];
            $existing->subTotal += $data['subTotal'];
            return $existing->save();
        } else {
            return static::create($data);
        }
    }

    public static function getKeranjang($idPelanggan)
    {
        // Pakai 'with' agar lebih cepat saat diloop di view
        return static::with('produk')->where('idPelanggan', $idPelanggan)->get();
    }

    public static function hapusDariKeranjang($idKeranjang)
    {
        return static::destroy($idKeranjang);
    }

    public static function hapusKeranjang($idPelanggan)
    {
        return static::where('idPelanggan', $idPelanggan)->delete();
    }
}