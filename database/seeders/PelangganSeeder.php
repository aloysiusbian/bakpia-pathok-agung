<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelanggan')->insert([
            'idPelanggan' => DB::raw('UUID()'),
            'password' => Hash::make('4444'),
            'email' => 'alberto@gmail.com',
            'alamat' => 'jalan kanigoro, kost rafi, paingan, Depok, Sleman, Yogyakarta',
            'noTelp' => '6282289183719',
        ]);
    }
}
