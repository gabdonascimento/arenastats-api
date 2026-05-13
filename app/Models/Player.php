<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'team_id',
        'name',
        'position',
        'shirt_number',
        'nationality',
        'birth_date',
        'overall',
        'photo',
        'is_active',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}