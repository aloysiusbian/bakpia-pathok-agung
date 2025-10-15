<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detailtransaksi_offline', function (Blueprint $table) {
            $table->foreignUuid('idPenjualan')->constrained('pemesananoffline', 'idPenjualan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('idProduk', 7)->constrained('produk', 'idProduk')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('jumlahBarang');
            $table->integer('hargaTransaksi');
            $table->decimal('discountPerProduk', 3, 2);
            $table->integer('sub');

            // Foreign Keys
//             $table->foreign('idPenjualan')->references('idPenjualan')->on('pemesananoffline');
//             $table->foreign('idProduk')->references('idProduk')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailtransaksi_offline');
    }
};
