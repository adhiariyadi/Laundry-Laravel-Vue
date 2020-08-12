<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'description', 'satuan', 'harga'
    ];

    public function cucian()
    {
        return $this->hasMany('App\Models\Cucian');
    }

    protected $table = 'category';
}
