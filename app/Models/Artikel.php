<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    // Tambahkan properti fillable agar admin bisa input artikel
    protected $fillable = [
        'judul',
        'konten',
        'gambar',
    ];
}
