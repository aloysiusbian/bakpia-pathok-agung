<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
       public function getDisplayImageAttribute()
{
    $namaFile = $this->gambar;

    // 1. Jika kolom kosong, kembalikan gambar default
    if (!$namaFile) {
        return asset('images/default.png');
    }

    // 2. CEK STORAGE (Untuk gambar hasil upload baru)
    // PERBAIKAN: Kita harus masuk ke folder 'produk_images/' karena controller menyimpannya di sana.
    if (Storage::disk('public')->exists('produk_images/' . $namaFile)) {
        return asset('storage/produk_images/' . $namaFile);
    }

    // 3. CEK PUBLIC BIASA (Untuk gambar bawaan/seeder/manual copy)
    // Mengecek di folder: public/images/
    if (file_exists(public_path('images/' . $namaFile))) {
        return asset('images/' . $namaFile);
    }
    
    // Mengecek di folder: public/ (langsung di root public)
    if (file_exists(public_path($namaFile))) {
        return asset($namaFile);
    }

    // 4. JIKA TIDAK KETEMU DI MANA-MANA
    return asset('images/default.png'); 
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
