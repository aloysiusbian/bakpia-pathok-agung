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
        Schema::create('pemesananonline', function (Blueprint $table) {
            $table->uuid('nomorPemesanan')->primary()->default(DB::raw('UUID()'));
            $table->foreignUuid('idPelanggan')->constrained('pelanggan', 'idPelanggan')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('tanggalPemesanan');
            $table->double('totalNota', 10, 2);
            $table->string('metodePembayaran', 10);
            $table->string('statusPesanan', 50);
            $table->decimal('discountPerNota', 3, 2);
            $table->text('alamatPengirim');

            // Foreign Key
//             $table->foreign('idPelanggan')->references('idPelanggan')->on('pelanggan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesananonline');
    }
};
