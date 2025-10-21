<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesananoffline', function (Blueprint $table) {
            $table->uuid('idPenjualan')->primary()->default(DB::raw('UUID()'));
            $table->string('namaPelanggan', 25);
            $table->date('tanggalPemesanan');
            $table->double('totalNota', 10, 2);
            $table->string('metodePembayaran', 10);
            $table->string('noTelpPelanggan');
            $table->text('alamatPengirim');
            $table->decimal('discountPerNota', 3, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesananoffline');
    }
};
