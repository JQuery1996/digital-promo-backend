<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'ExternalId',
        'operatorId',
        'type',
        'subType',
        'name',
    ];
}
    