<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Masukkan data ke tabel 'alamat_pelanggan'
        DB::table('alamat')->insert([
            // Alamat untuk Pelanggan ID 1
            [
                'idPelanggan' => 1,
                'judul_alamat' => 'Rumah Utama',
                'alamat_lengkap' => 'Jl. Kenanga No. 45, Komplek Mawar, Jakarta Selatan, 12345',
                'is_utama' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPelanggan' => 1,
                'judul_alamat' => 'Kantor',
                'alamat_lengkap' => 'Gedung Biru Lantai 5, Kawasan Industri, Jakarta Pusat, 54321',
                'is_utama' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
