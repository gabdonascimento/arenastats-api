<?php

namespace App\Http\Controllers;

use App\Models\MatchGame;
use Illuminate\Http\Request;

class MatchGameController extends Controller
{
    public function index()
    {
        return response()->json(
            MatchGame::with(['competition', 'round', 'homeTeam', 'awayTeam'])
                ->orderBy('match_date')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'competition_id' => 'nullable|exists:competitions,id',
            'round_id' => 'nullable|exists:rounds,id',
            'home_team_id' => 'required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'required|exists:teams,id',
            'match_date' => 'required|date',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'required|string|in:scheduled,live,finished,postponed,canceled',
            'stadium' => 'nullable|string|max:255',
        ]);

        $matchGame = MatchGame::create($data);

        return response()->json(
            $matchGame->load(['homeTeam', 'awayTeam']),
            201
        );
    }

    public function show(MatchGame $match)
    {
        return response()->json(
            $match->load([
                'competition',
                'round',
                'homeTeam',
                'awayTeam'
            ])
        );
    }
    public function update(Request $request, MatchGame $match)
    {
        $data = $request->validate([
            'competition_id' => 'nullable|exists:competitions,id',
            'round_id' => 'nullable|exists:rounds,id',
            'home_team_id' => 'sometimes|required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'sometimes|required|exists:teams,id',
            'match_date' => 'sometimes|required|date',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'sometimes|required|string|in:scheduled,live,finished,postponed,canceled',
            'stadium' => 'nullable|string|max:255',
        ]);

        $match->update($data);

        return response()->json(
            $match->load(['competition', 'round', 'homeTeam', 'awayTeam'])
        );
    }

    public function destroy(MatchGame $match)
    {
        $match->delete();

        return response()->json([
            'message' => 'Partida excluída com sucesso.'
        ]);
    }

    public function timeline(MatchGame $match)
    {
        $events = $match->events()
            ->with(['team', 'player', 'assistPlayer'])
            ->orderBy('minute')
            ->get();

        return response()->json([
            'match' => $match->load(['competition', 'homeTeam', 'awayTeam']),
            'timeline' => $events
        ]);
    }
}