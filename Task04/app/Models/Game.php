<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'player_name',
        'progression',
        'hidden_number',
        'player_answer',
        'result',
    ];
}
