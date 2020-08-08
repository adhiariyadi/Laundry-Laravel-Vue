<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kas extends Model
{
    protected $fillable = [
        'invoice', 'description', 'ket', 'jumlah'
    ];

    protected $table = 'kas';
}
