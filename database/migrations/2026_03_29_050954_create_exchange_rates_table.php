<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('exchange_rates', function (Blueprint $table) {
        $table->id();
        $table->string('currency')->unique(); // SAR, USD
        $table->decimal('rate', 15, 2); // Nilai dalam Rupiah (Contoh: 4300.00)
        $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
