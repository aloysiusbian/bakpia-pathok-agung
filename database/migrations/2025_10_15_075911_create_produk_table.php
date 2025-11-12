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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('idProduk', 7)->primary();
            $table->string('namaProduk', 100);
            $table->text('deskripsiProduk');
            $table->string('pilihanJenis', 3);
            $table->string('kategori', 50);
            $table->decimal('rating', 2, 1);
            $table->double('harga', 10, 2);
            $table->integer('stok');
            $table->text('gambar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
