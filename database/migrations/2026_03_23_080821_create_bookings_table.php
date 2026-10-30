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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained(); // ID Agen yang login
        $table->foreignId('package_id')->constrained(); // ID Paket Umroh
        $table->integer('jumlah_jamaah');
        $table->decimal('total_tagihan', 15, 2);
        $table->string('status')->default('pending'); // pending, lunas, batal
        $table->string('bukti_bayar')->nullable(); // Path foto struk
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
