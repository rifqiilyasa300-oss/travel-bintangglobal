<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nama_paket',
        'image',
        'deskripsi',
        'harga_agen',
        'currency',
        'kuota_awal',
        'sisa_kuota',
        'category',
        'include_bus' // <--- WAJIB TAMBAHKAN INI AGAR DATA BISA DISIMPAN
    ];
}
