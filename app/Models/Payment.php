<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini diisi sesuai migration yang Anda buat tadi
    protected $fillable = [
        'booking_id',
        'external_id',
        'amount_paid',
        'payment_method',
        'proof_of_payment',
        'status',
    ];

    /**
     * Relasi balik ke Booking (Satu pembayaran milik satu booking)
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
