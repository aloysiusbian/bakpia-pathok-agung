<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produk')->insert([
            [
                'idProduk' => '1',
                'namaProduk' => 'Bakpia Coklat',
                'deskripsiProduk' => 'Bakpia Coklat adalah kue khas Yogyakarta berbentuk bulat pipih dengan tekstur kulit yang lembut dan sedikit renyah di bagian luar. Di dalamnya berisi isian coklat manis yang lumer dan harum, memberikan perpaduan rasa gurih kulit bakpia dan manis legit coklat. Cocok dinikmati sebagai camilan santai, teman minum teh atau kopi, maupun oleh-oleh khas yang disukai semua kalangan',
                'pilihanJenis' => '5',
                'kategori' => 'Bakpia',
                'rating' => 4.0,
                'harga' => 15000.00,
                'stok' => 60,
            ],
            [
                'idProduk' => '2',
                'namaProduk' => 'Bakpia Kacang',
                'deskripsiProduk' => 'Bakpia Kacang adalah kue tradisional khas Yogyakarta berbentuk bulat pipih dengan kulit tipis yang lembut dan sedikit renyah. Di dalamnya berisi pasta kacang hijau manis-gurih yang diolah hingga halus, memberikan rasa legit yang khas dan aroma harum yang menggoda. Cocok dinikmati sebagai camilan, teman minum teh atau kopi, maupun sebagai oleh-oleh khas yang tak lekang oleh waktu.',
                'pilihanJenis' => '5',
                'kategori' => 'Bakpia',
                'rating' => 4.0,
                'harga' => 10000.00,
                'stok' => 30,
            ],
            [
                'idProduk' => '3',
                'namaProduk' => 'Bakpia Durian',
                'deskripsiProduk' => 'Bakpia Durian adalah kue khas Yogyakarta berbentuk bulat pipih dengan kulit lembut dan sedikit renyah, berisi pasta durian yang manis, legit, dan harum khas buah durian. Setiap gigitan menghadirkan perpaduan rasa gurih kulit bakpia dan kelezatan daging durian yang creamy, menjadikannya pilihan istimewa bagi pecinta durian maupun penikmat camilan tradisional.',
                'pilihanJenis' => '5',
                'kategori' => 'Bakpia',
                'rating' => 4.0,
                'harga' => 10000.00,
                'stok' => 30,
            ],
        ]);
    }
}
