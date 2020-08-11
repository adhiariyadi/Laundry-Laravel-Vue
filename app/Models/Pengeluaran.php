<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'invoice', 'description', 'jumlah', 'operator'
    ];

    public function operator()
    {
        return $this->belongsTo('App\User', 'operator');
    }

    protected $table = 'pengeluaran';
}
