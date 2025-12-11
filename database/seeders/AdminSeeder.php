<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin')->insert([
            'idAdmin' => '1',
            'username' => 'biann',
            'password' => Hash::make('bian123'),
            'email' => 'bian@gmail.com',
            'image' => 'foto_profil/bian.png',
        ]);
    }
}
