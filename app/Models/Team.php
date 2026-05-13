<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Player;

class Team extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'slug',
        'country',
        'city',
        'founded_year',
        'logo',
        'is_active',
    ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}