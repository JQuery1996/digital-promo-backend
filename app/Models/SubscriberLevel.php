<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriberLevel extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'gameId',
        'Msisdn',
        'levelId',
        'rounds',
        'tries',
        'status',
    ];
}

