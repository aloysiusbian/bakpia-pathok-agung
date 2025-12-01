<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'guard' => 'web',      // guard default = web (pelanggan)
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    */

    'guards' => [
        // Guard untuk PELANGGAN
        'web' => [
            'driver' => 'session',
            'provider' => 'users',   // <-- PENTING: pakai 'users', bukan 'pelanggan'
        ],

        // Guard untuk ADMIN
        'admin' => [
            'driver' => 'session',
            'provider' => 'admin',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Di sini kita TIDAK ganti nama 'users', hanya ganti modelnya
    */

    'providers' => [

        // PROVIDER UNTUK PELANGGAN (dipakai guard 'web')
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Pelanggan::class,  // <- model pelanggan
        ],

        // PROVIDER UNTUK ADMIN (dipakai guard 'admin')
        'admin' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */

    'passwords' => [
        'users' => [
            // provider HARUS sama dengan key di 'providers'
            'provider' => 'users',    // <-- bukan 'pelanggan'
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
