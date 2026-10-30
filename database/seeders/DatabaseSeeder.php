<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       \App\Models\Package::create([
            'nama_paket' => 'Umroh Syawal 2026 - Pesawat Garuda',
            'harga_agen' => 25000000,
            'kuota_awal' => 45,
            'sisa_kuota' => 45,
]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
