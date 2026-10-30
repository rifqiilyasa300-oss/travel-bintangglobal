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
    Schema::create('packages', function (Blueprint $table) {
        $table->id();
        $table->string('nama_paket');
        $table->bigInteger('harga_agen'); // Pakai bigInteger buat nominal jutaan
        $table->integer('stok_kursi');
        $table->timestamps(); // Ini buat created_at & updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
