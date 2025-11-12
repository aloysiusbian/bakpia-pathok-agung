<?php

namespace Database\Seeders;

use App\Models\Produk;
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
                'pilihanJenis' => '15',
                'kategori' => 'Bakpia',
                'rating' => 4.0,
                'harga' => 38000.00,
                'stok' => 60,
                'gambar' => 'bakpia-cokelat.jpg'
            ],
            [
                'idProduk' => '2',
                'namaProduk' => 'Bakpia Kacang Hijau',
                'deskripsiProduk' => 'Bakpia Kacang adalah kue tradisional khas Yogyakarta berbentuk bulat pipih dengan kulit tipis yang lembut dan sedikit renyah. Di dalamnya berisi pasta kacang hijau manis-gurih yang diolah hingga halus, memberikan rasa legit yang khas dan aroma harum yang menggoda. Cocok dinikmati sebagai camilan, teman minum teh atau kopi, maupun sebagai oleh-oleh khas yang tak lekang oleh waktu.',
                'pilihanJenis' => '15',
                'kategori' => 'Bakpia',
                'rating' => 4.0,
                'harga' => 38000.00,
                'stok' => 30,
                'gambar' => 'bakpia-kacang-hijau.jpg'
            ],
            [
                'idProduk' => '3',
                'namaProduk' => 'Bakpia Kumbu Hitam',
                'deskripsiProduk' => 'Bakpia Kumbu Hitam adalah kue khas Yogyakarta berbentuk bulat pipih dengan kulit lembut dan sedikit renyah, berisi pasta kacang tolo hitam yang manis, legit, dan bertekstur lembut. Setiap gigitan menghadirkan perpaduan rasa gurih kulit bakpia dan kelezatan khas kacang tolo hitam yang sedikit menyerupai cokelat, menjadikannya pilihan istimewa bagi penikmat rasa otentik dengan sentuhan unik.',
                'pilihanJenis' => '15',
                'kategori' => 'Bakpia',
                'rating' => 4.0,
                'harga' => 38000.00,
                'stok' => 30,
                'gambar' => 'bakpia-kumbu-hitam.jpg'
            ],
            [
                'idProduk' => '4',
                'namaProduk' => 'Bakpia Keju',
                'deskripsiProduk' => 'Bakpia Keju adalah kue khas Yogyakarta berbentuk bulat pipih dengan kulit lembut dan sedikit renyah, berisi selai keju yang gurih, legit, dan harum khas keju. Setiap gigitan menghadirkan perpaduan rasa gurih kulit bakpia dan kelezatan selai keju yang creamy, menjadikannya pilihan istimewa bagi pecinta keju maupun penikmat camilan tradisional.',
                'pilihanJenis' => '15',
                'kategori' => 'Bakpia',
                'rating' => 4.0,
                'harga' => 38000.00,
                'stok' => 35,
                'gambar' => 'bakpia-keju.jpg'
            ],
        ]);
    }
}
