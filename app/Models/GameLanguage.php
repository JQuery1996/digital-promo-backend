<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLanguage extends Model
{
    use HasFactory;
    protected $fillable = [
        'gameId',
        'languageId',
        'name',
        'description',
    ];
}
 
