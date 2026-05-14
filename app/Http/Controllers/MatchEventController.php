<?php

namespace App\Http\Controllers;

use App\Models\MatchEvent;
use Illuminate\Http\Request;

class MatchEventController extends Controller
{
    public function index()
    {
        return response()->json(
            MatchEvent::with(['match', 'team', 'player', 'assistPlayer'])
                ->orderBy('minute')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'match_game_id' => 'required|exists:match_games,id',
            'team_id' => 'required|exists:teams,id',
            'player_id' => 'nullable|exists:players,id',
            'assist_player_id' => 'nullable|exists:players,id',
            'type' => 'required|string|in:goal,yellow_card,red_card,substitution',
            'minute' => 'required|integer|min:1|max:130',
        ]);

        $event = MatchEvent::create($data);

        return response()->json(
            $event->load(['match', 'team', 'player', 'assistPlayer']),
            201
        );
    }

    public function show(MatchEvent $matchEvent)
    {
        return response()->json(
            $matchEvent->load(['match', 'team', 'player', 'assistPlayer'])
        );
    }

    public function destroy(MatchEvent $matchEvent)
    {
        $matchEvent->delete();

        return response()->json([
            'message' => 'Evento excluído com sucesso.'
        ]);
    }
}