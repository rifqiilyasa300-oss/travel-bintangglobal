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
        Schema::create('manifests', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel bookings
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');

            // Data Identitas
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin')->nullable(); // Laki-laki / Perempuan
            $table->string('nomor_paspor')->nullable();

            // Data Kamar
            $table->string('grup_kamar')->nullable(); // Contoh: Kamar 01, Kamar 02
            $table->string('tipe_kamar')->nullable(); // Contoh: Quad, Triple, Double

            // Data Lampiran Dokumen
            $table->string('foto_paspor')->nullable(); // Untuk simpan file Scan Paspor
            $table->string('pasfoto')->nullable();     // Untuk simpan file Pasfoto (wajah)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manifests');
    }
};
