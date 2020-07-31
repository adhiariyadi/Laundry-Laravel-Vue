<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'kode', 'description', 'discount'
    ];

    protected $table = 'promo';
}
