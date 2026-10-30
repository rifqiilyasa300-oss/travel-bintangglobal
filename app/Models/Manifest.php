<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manifest extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'nama_lengkap',
        'jenis_kelamin',
        'nomor_paspor',
        'grup_kamar',
        'tipe_kamar',
        'foto_paspor',
        'pasfoto',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
