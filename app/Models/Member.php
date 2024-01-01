<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $fillable = [
        'access_level',
        'board_id',
        'user_id',
        'expiration'
    ];

    protected $casts = [
        'access_level' => 'array'
    ];
}
