<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
