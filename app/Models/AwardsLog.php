<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'awardId',
        'levelId',
        'gameId',
        'Msisdn',
        'CreationTimestamp',
    ];
}

