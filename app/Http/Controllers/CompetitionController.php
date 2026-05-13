<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompetitionController extends Controller
{
    public function index()
    {
        return response()->json(Competition::orderBy('name')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:competitions,name',
            'country' => 'nullable|string|max:100',
            'type' => 'required|string|in:league,cup,continental,friendly',
            'logo' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $competition = Competition::create($data);

        return response()->json($competition, 201);
    }

    public function show(Competition $competition)
    {
        return response()->json($competition);
    }

    public function update(Request $request, Competition $competition)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:competitions,name,' . $competition->id,
            'country' => 'nullable|string|max:100',
            'type' => 'sometimes|required|string|in:league,cup,continental,friendly',
            'logo' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $competition->update($data);

        return response()->json($competition);
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();

        return response()->json([
            'message' => 'Competição excluída com sucesso.'
        ]);
    }
}