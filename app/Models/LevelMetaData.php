<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelMetaData extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'levelId',
        'key',
        'value',
    ];
}

