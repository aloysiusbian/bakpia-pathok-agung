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
        'jumlahBarang'
    ];
    
    public static function tambahKeKeranjang($data)
{
    // Cek apakah produk sudah ada di keranjang untuk pelanggan INI
    $existing = static::where('idProduk', $data['idProduk'])
                      ->where('idPelanggan', $data['idPelanggan'])
                      ->first();

    if ($existing) {
        // Update jumlah dan total (Gunakan nama kolom yang benar)
        $existing->jumlahBarang += $data['jumlahBarang'];
        $existing->subTotal += $data['subTotal'];
        return $existing->save(); // Cara Eloquent untuk update
    } else {
        // Tambah baru (Cara Eloquent untuk insert)
        return static::create($data);
    }
}

    public static function getKeranjang($idPelanggan)
{
    // Mengambil semua item keranjang untuk pelanggan tertentu
    return static::where('idPelanggan', $idPelanggan)->get();
}
    public static function hapusDariKeranjang($idKeranjang)
{
    return static::destroy($idKeranjang);
}

    public static function hapusKeranjang($idPelanggan)
{
    // Menghapus semua item keranjang untuk pelanggan tertentu
    return static::where('idPelanggan', $idPelanggan)->delete();
}
}
