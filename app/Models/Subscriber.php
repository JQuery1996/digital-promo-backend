<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Subscriber extends  Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'id',
        'Msisdn',
        'operatorId',
        'lastPlayDate',
        'status',
        'daliyBalanceDate',
        'daliyBalanceValue',
        'monthlyBalanceValue',
        'monthlyBalanceDate'

    ];
}
