<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'invoice', 'antrian_id', 'waktu', 'jumlah_cuci', 'harga', 'discount', 'total', 'bayar', 'kembali', 'payment_method', 'operator'
    ];

    public function antrian()
    {
        return $this->belongsTo('App\Models\Antrian', 'antrian_id');
    }

    public function kas()
    {
        return $this->hasOne('App\Models\Kas', 'invoice', 'invoice');
    }

    public function operator()
    {
        return $this->belongsTo('App\User', 'operator');
    }

    protected $table = 'pembayaran';
}
