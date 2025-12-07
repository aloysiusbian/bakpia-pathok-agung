<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds. tes
     */
    public function run(): void
    {
        DB::table('pelanggan')->insert([
            'idPelanggan' => 1,
            'username' => 'Alberto Safanda',
            'password' => Hash::make('4444'),
            'email' => 'alberto@gmail.com',
            'noTelp' => '6282289183719',
            'image' => 'berto.jpg',
        ]);
    }
}
