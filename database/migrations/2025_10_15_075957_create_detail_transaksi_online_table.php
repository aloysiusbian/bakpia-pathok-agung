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
        Schema::create('detailtransaksi_online', function (Blueprint $table) {
            $table->foreignUuid('nomorPemesanan')->constrained('pemesananonline', 'nomorPemesanan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('idProduk', 7)->constrained('produk', 'idProduk')->cascadeOnDelete()->cascadeOnUpdate();;
            $table->integer('jumlahBarang');
            $table->integer('harga');
            $table->decimal('discountPerProduk', 3, 2);
            $table->integer('subTotal');

            // Foreign Keys tes
//             $table->foreign('nomorPemesanan')->references('nomorPemesanan')->on('pemesananonline');
//             $table->foreign('idProduk')->references('idProduk')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailtransaksi_online');
    }
};
