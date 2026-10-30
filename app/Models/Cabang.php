<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    // Tambahkan ini supaya data bisa masuk ke database
    protected $fillable = [
        'nama_cabang',
        'lokasi',
        'total_agen'
    ];
}
