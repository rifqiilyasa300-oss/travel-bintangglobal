<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    use HasFactory;

    // Field yang boleh diisi
    protected $fillable = [
        'booking_id',
        'nama_layanan',
        'qty',
        'harga',
        'keterangan'
    ];

    /**
     * Relasi ke arah Induk (Booking)
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
