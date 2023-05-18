<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'gameId',
        'number',
        'poolId',
        'tries',
        'description',
        'rounds',
    ];

    public function Game(){
        return $this->belongsTo('App\Game');
    }
}

