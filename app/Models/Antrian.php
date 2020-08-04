<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
    protected $fillable = [
        'member_id', 'date', 'selesai', 'ambil', 'pembayaran', 'operator', 'status'
    ];

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id');
    }

    public function operator()
    {
        return $this->belongsTo('App\User', 'operator');
    }

    protected $table = 'antrian';
}
