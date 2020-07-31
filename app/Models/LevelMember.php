<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelMember extends Model
{
    protected $fillable = [
        'name', 'point', 'discount'
    ];

    protected $table = 'level_member';
}
