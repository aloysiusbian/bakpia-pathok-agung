<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keranjang', function (Blueprint $table) {
            $table->uuid('idKeranjang')->primary()->default(DB::raw('UUID()'));
            $table->foreignId('idPelanggan')->constrained('pelanggan', 'idPelanggan')->cascadeOnDelete()->cascadeOnUpdate();;
            $table->foreignId('idProduk', 7)->constrained('produk', 'idProduk')->cascadeOnDelete()->cascadeOnUpdate();;
            $table->double('subTotal', 10, 2);
            $table->integer('jumlahBarang', 5);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
