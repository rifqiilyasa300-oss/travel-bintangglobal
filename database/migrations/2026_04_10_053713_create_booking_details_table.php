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
        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();

            // Menghubungkan detail ini ke ID Booking utama
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');

            $table->string('nama_layanan'); // Contoh: "Paket LA", "Hotel", "Bus"
            $table->integer('qty')->default(1);
            $table->decimal('harga', 15, 2); // Harga satuan
            $table->text('keterangan')->nullable(); // Catatan tambahan (Periode, Nama Hotel, dll)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
