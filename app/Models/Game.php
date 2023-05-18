<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'route',
        'image',
        'description',
    ];

    public function Level(){
        return $this->hasMany('App\Level','gameId');
    }
}

