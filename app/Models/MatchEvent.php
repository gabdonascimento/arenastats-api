<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MatchGame;
use App\Models\Team;
use App\Models\Player;

class MatchEvent extends Model
{
    protected $fillable = [
        'match_game_id',
        'team_id',
        'player_id',
        'assist_player_id',
        'type',
        'minute',
    ];

    public function match()
    {
        return $this->belongsTo(MatchGame::class, 'match_game_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function assistPlayer()
    {
        return $this->belongsTo(Player::class, 'assist_player_id');
    }
}