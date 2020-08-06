<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cucian extends Model
{
    protected $fillable = [
        'antrian_id', 'category_id', 'harga', 'quantity', 'total'
    ];

    public function antrian()
    {
        return $this->belongsTo('App\Models\Antrian', 'antrian_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    protected $table = 'cucian';
}
