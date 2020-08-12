<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name', 'alamat', 'telp', 'level_id', 'point'
    ];

    public function level()
    {
        return $this->belongsTo('App\Models\LevelMember', 'level_id');
    }

    public function antrian()
    {
        return $this->hasMany('App\Models\Antrian');
    }

    protected $table = 'member';
}
