<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'antrian_id', 'total', 'saldo', 'operator', 'status'
    ];

    public function antrian()
    {
        return $this->belongsTo('App\Models\Antrian', 'antrian_id');
    }

    public function operator()
    {
        return $this->belongsTo('App\User', 'operator');
    }

    protected $table = 'room';
}
