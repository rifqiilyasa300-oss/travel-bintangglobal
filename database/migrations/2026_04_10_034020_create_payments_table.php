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
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('booking_id')->constrained()->onDelete('cascade');
        $table->integer('amount_paid');
        $table->string('payment_method'); // BCA, BSI, TUNAI, dll
        $table->string('proof_of_payment')->nullable(); // Foto bukti
        $table->string('status')->default('pending'); // pending, success, failed
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
