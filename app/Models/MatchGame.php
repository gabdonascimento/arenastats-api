<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use App\Models\Competition;

class MatchGame extends Model
{
    protected $fillable = [
        'competition_id',
        'home_team_id',
        'away_team_id',
        'match_date',
        'home_score',
        'away_score',
        'status',
        'stadium',
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
}