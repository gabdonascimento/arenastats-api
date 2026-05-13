<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        return response()->json(
    Team::with('players')
        ->orderBy('name')
        ->get()
);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'short_name' => 'required|string|max:10',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'logo' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $team = Team::create($data);

        return response()->json($team, 201);
    }

    public function show(Team $team)
    {
        return response()->json($team);
    }

    public function update(Request $request, Team $team)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:teams,name,' . $team->id,
            'short_name' => 'sometimes|required|string|max:10',
            'country' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:255',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'logo' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $team->update($data);

        return response()->json($team);
    }

    public function destroy(Team $team)
    {
        $team->delete();

        return response()->json([
            'message' => 'Time excluído com sucesso.'
        ]);
    }
}