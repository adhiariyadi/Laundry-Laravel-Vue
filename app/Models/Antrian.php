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

    public function room()
    {
        return $this->hasOne('App\Models\Room');
    }

    public function cucian()
    {
        return $this->hasMany('App\Models\Cucian');
    }

    public function bayar()
    {
        return $this->hasOne('App\Models\Pembayaran');
    }

    public function operator()
    {
        return $this->belongsTo('App\User', 'operator');
    }

    protected $table = 'antrian';
}
