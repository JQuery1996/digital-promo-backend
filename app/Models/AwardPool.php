<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardPool extends Model
{
    use HasFactory;
    protected $fillable = [
        'awardId',
        'poolId',
        'count',
        'remaining',

    ];
}

