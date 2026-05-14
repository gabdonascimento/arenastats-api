<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\MatchEvent;

class StatisticController extends Controller
{
    public function topScorers(Competition $competition)
    {
        $scorers = MatchEvent::with(['player', 'team', 'match'])
            ->where('type', 'goal')
            ->whereHas('match', function ($query) use ($competition) {
                $query->where('competition_id', $competition->id);
            })
            ->get()
            ->groupBy('player_id')
            ->map(function ($events) {

                $firstEvent = $events->first();

                return [
                    'player' => $firstEvent->player->name,
                    'team' => $firstEvent->team->name,
                    'goals' => $events->count(),
                ];
            })
            ->sortByDesc('goals')
            ->values();

        return response()->json([
            'competition' => $competition->name,
            'top_scorers' => $scorers
        ]);
    }
}