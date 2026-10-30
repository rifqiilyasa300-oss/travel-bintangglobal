<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'nama_group',
        'nama_hotel',
        'jenis_kamar',
        'check_in',
        'check_out',
        'jumlah_kamar',
        'jumlah_jamaah',
        'total_tagihan',
        'status',
        'metode_bayar',
        'bukti_bayar',
    ];

    /**
     * Appends digunakan agar Accessor (total_paid & amount_due)
     * muncul otomatis saat data diubah ke JSON/Array.
     */
    protected $appends = ['total_paid', 'amount_due'];

    // --- RELASI ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id')->withTrashed();
    }

    public function manifests()
    {
        return $this->hasMany(Manifest::class);
    }

    /**
     * Relasi ke item detail (Hotel, Bus, dll)
     */
    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }

    /**
     * Relasi ke riwayat pembayaran (Cicilan)
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // --- LOGIKA BISNIS ---

    /**
     * Fungsi untuk menghitung ulang total_tagihan berdasarkan
     * akumulasi semua item di tabel booking_details.
     */
    public function updateGrandTotal()
    {
        // Hitung sum dari (qty * harga) pada relasi details
        $totalLayanan = $this->details()->sum(DB::raw('qty * harga'));

        // Simpan ke kolom total_tagihan di tabel bookings
        return $this->update([
            'total_tagihan' => $totalLayanan
        ]);
    }

    // --- ACCESSORS (LOGIKA OTOMATIS) ---

    /**
     * Mendapatkan total uang yang sudah dibayar
     * Sesuai screenshot DB: Mengambil status 'pending' agar angka muncul di invoice
     */
    public function getTotalPaidAttribute()
    {
        // Kita hitung yang statusnya 'pending' atau 'success' agar angka Rp 0 hilang
        return $this->payments()
                    ->whereIn('status', ['pending', 'success', 'LUNAS'])
                    ->sum('amount_paid');
    }

    /**
     * Mendapatkan sisa tagihan (Amount Due)
     */
    public function getAmountDueAttribute()
    {
        $total = $this->total_tagihan ?? 0;
        $paid = $this->total_paid;

        $diff = $total - $paid;

        // Gunakan max(0) supaya tidak muncul angka minus jika user bayar lebih
        return $diff < 0 ? 0 : $diff;
    }
}
