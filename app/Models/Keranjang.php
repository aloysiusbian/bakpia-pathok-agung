<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'nomorPemesanan';
    public $timestamps = false;
    protected $fillable = [
        'idProduk',
        'totalNota',
    ];
    public function tambahKeKeranjang($data)
{
    // Cek apakah produk sudah ada di keranjang
    $existing = $this->where('idProduk', $data['idProduk'])->first();

    if ($existing) {
        // Update jumlah dan total
        $data['jumlah_barang'] += $existing->jumlah_barang;
        $data['total_harga'] += $existing->total_harga;
        return $this->update($existing->idPemesanan, $data);
    } else {
        // Tambah baru
        return $this->insert($data);
    }
}

    public function getKeranjang()
    {
        return $this->findAll();
    }
    public function hapusDariKeranjang($nomorPemesanan)
    {
        return $this->delete($nomorPemesanan);
    }

    public function hapusKeranjang()
    {
        return $this->emptyTable();
    }
}
