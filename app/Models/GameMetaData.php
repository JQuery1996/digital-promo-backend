<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameMetaData extends Model
{
    use HasFactory;
    protected $fillable = [
        'gameId',
        'id',
        'key',
        'value',
    ];
}

