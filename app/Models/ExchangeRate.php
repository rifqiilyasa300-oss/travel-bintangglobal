<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    // Beri tahu Laravel nama tabelnya
    protected $table = 'exchange_rates';

    // Kolom mana saja yang boleh diisi
    protected $fillable = ['currency', 'rate'];
}
