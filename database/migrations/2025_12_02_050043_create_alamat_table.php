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
        // app/database/migrations/xxxx_xx_xx_create_pelanggan_alamat_table.php

        Schema::create('alamat', function (Blueprint $table) {
            $table->id(); // Kunci utama untuk tabel alamat
            $table->foreignId('idPelanggan')->constrained('pelanggan', 'idPelanggan')->onDelete('cascade'); // Kunci asing
            $table->string('judul_alamat')->nullable(); // Contoh: 'Rumah', 'Kantor', 'Alamat 2'
            $table->text('alamat_lengkap');
            $table->string('kode_pos', 10)->nullable();
            $table->boolean('is_utama')->default(false); // Untuk menandai alamat utama
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};
