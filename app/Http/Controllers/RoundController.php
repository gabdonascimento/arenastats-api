<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\Request;

class RoundController extends Controller
{
    public function index()
    {
        return response()->json(
            Round::with(['competition', 'matches.homeTeam', 'matches.awayTeam'])
                ->orderBy('number')
                ->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'competition_id' => 'required|exists:competitions,id',
            'number' => 'required|integer|min:1',
            'name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $round = Round::create($data);

        return response()->json($round->load('competition'), 201);
    }

    public function show(Round $round)
    {
        return response()->json(
            $round->load(['competition', 'matches.homeTeam', 'matches.awayTeam'])
        );
    }

    public function destroy(Round $round)
    {
        $round->delete();

        return response()->json([
            'message' => 'Rodada excluída com sucesso.'
        ]);
    }
}