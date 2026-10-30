<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Cek satu-satu, kalau belum ada baru buat
            if (!Schema::hasColumn('bookings', 'nama_hotel')) {
                $table->string('nama_hotel')->nullable()->after('package_id');
            }
            if (!Schema::hasColumn('bookings', 'check_in')) {
                $table->date('check_in')->nullable()->after('nama_hotel');
            }
            if (!Schema::hasColumn('bookings', 'check_out')) {
                $table->date('check_out')->nullable()->after('check_in');
            }
            if (!Schema::hasColumn('bookings', 'jumlah_kamar')) {
                $table->integer('jumlah_kamar')->default(0)->after('check_out');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['nama_hotel', 'check_in', 'check_out', 'jumlah_kamar']);
        });
    }
};
