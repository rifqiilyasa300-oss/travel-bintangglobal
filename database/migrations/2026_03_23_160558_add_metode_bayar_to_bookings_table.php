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
        Schema::table('bookings', function (Blueprint $table) {
            // Kita cek dulu: Apakah kolom 'metode_bayar' BELUM ADA?
            if (!Schema::hasColumn('bookings', 'metode_bayar')) {
                $table->string('metode_bayar')->nullable()->after('total_tagihan');
            }

            // SEKALIAN tambahkan kolom hotel yang tadi error (biar tidak kerja dua kali)
            if (!Schema::hasColumn('bookings', 'nama_hotel')) {
                $table->string('nama_hotel')->nullable()->after('package_id');
                $table->date('check_in')->nullable()->after('nama_hotel');
                $table->date('check_out')->nullable()->after('check_in');
                $table->integer('jumlah_kamar')->default(0)->after('check_out');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['metode_bayar', 'nama_hotel', 'check_in', 'check_out', 'jumlah_kamar']);
        });
    }
};
