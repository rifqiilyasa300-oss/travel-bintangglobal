<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'nama_travel',   // <--- Tambah ini
    'no_wa',         // <--- Tambah ini
    'alamat_kantor', // <--- Tambah ini
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- TAMBAHKAN INI DI SINI ---
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
