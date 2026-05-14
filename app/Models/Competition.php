<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'country',
        'type',
        'logo',
        'is_active',
    ];

    public function rounds()
    {
        return $this->hasMany(Round::class);
    }

}