<?php

namespace App\Http\Controllers;

use App\Models\MatchGame;
use Illuminate\Http\Request;

class MatchGameController extends Controller
{
    public function index()
    {
        return response()->json(
            MatchGame::with(['competition', 'homeTeam', 'awayTeam'])
                ->orderBy('match_date')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'competition_id' => 'nullable|exists:competitions,id',
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

    public function show(MatchGame $matchGame)
    {
        return response()->json(
            $matchGame->load(['homeTeam', 'awayTeam'])
        );
    }

    public function update(Request $request, MatchGame $matchGame)
    {
        $data = $request->validate([
            'competition_id' => 'nullable|exists:competitions,id',
            'home_team_id' => 'sometimes|required|exists:teams,id|different:away_team_id',
            'away_team_id' => 'sometimes|required|exists:teams,id',
            'match_date' => 'sometimes|required|date',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'sometimes|required|string|in:scheduled,live,finished,postponed,canceled',
            'stadium' => 'nullable|string|max:255',
        ]);

        $matchGame->update($data);

        return response()->json(
            $matchGame->load(['homeTeam', 'awayTeam'])
        );
    }

    public function destroy(MatchGame $matchGame)
    {
        $matchGame->delete();

        return response()->json([
            'message' => 'Partida excluída com sucesso.'
        ]);
    }
}