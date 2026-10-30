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
    Schema::table('bookings', function (Blueprint $table) {
        $table->string('nama_group')->nullable()->after('package_id');
        $table->string('jenis_kamar')->nullable()->after('jumlah_kamar');
    });
}

public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn(['nama_group', 'jenis_kamar']);
    });
}
};
