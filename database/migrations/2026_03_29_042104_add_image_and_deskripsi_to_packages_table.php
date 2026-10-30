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
        Schema::table('packages', function (Blueprint $table) {
            // Menambahkan kolom image untuk upload foto/brosur
            $table->string('image')->nullable()->after('nama_paket');

            // Menambahkan kolom deskripsi (Text) untuk detail & fasilitas paket
            $table->text('deskripsi')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn(['image', 'deskripsi']);
        });
    }
};
