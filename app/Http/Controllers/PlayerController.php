<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        return response()->json(
            Player::with('team')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:100',
            'shirt_number' => 'nullable|integer|min:1|max:99',
            'nationality' => 'required|string|max:100',
            'birth_date' => 'nullable|date',
            'overall' => 'nullable|integer|min:0|max:99',
            'photo' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $player = Player::create($data);

        return response()->json($player, 201);
    }

    public function show(Player $player)
    {
        return response()->json(
            $player->load('team')
        );
    }

    public function update(Request $request, Player $player)
    {
        $data = $request->validate([
            'team_id' => 'sometimes|required|exists:teams,id',
            'name' => 'sometimes|required|string|max:255',
            'position' => 'sometimes|required|string|max:100',
            'shirt_number' => 'nullable|integer|min:1|max:99',
            'nationality' => 'sometimes|required|string|max:100',
            'birth_date' => 'nullable|date',
            'overall' => 'nullable|integer|min:0|max:99',
            'photo' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $player->update($data);

        return response()->json($player);
    }

    public function destroy(Player $player)
    {
        $player->delete();

        return response()->json([
            'message' => 'Jogador excluído com sucesso.'
        ]);
    }
}