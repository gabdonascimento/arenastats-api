<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\MatchGame;

class StandingController extends Controller
{
    public function index(Competition $competition)
    {
        $matches = MatchGame::with(['homeTeam', 'awayTeam'])
            ->where('competition_id', $competition->id)
            ->where('status', 'finished')
            ->get();

        $table = [];

        foreach ($matches as $match) {

            $homeTeam = $match->homeTeam;
            $awayTeam = $match->awayTeam;

            // Inicializa time mandante
            if (!isset($table[$homeTeam->id])) {
                $table[$homeTeam->id] = [
                    'team' => $homeTeam->name,
                    'points' => 0,
                    'matches' => 0,
                    'wins' => 0,
                    'draws' => 0,
                    'losses' => 0,
                    'goals_for' => 0,
                    'goals_against' => 0,
                    'goal_difference' => 0,
                ];
            }

            // Inicializa time visitante
            if (!isset($table[$awayTeam->id])) {
                $table[$awayTeam->id] = [
                    'team' => $awayTeam->name,
                    'points' => 0,
                    'matches' => 0,
                    'wins' => 0,
                    'draws' => 0,
                    'losses' => 0,
                    'goals_for' => 0,
                    'goals_against' => 0,
                    'goal_difference' => 0,
                ];
            }

            // Jogos
            $table[$homeTeam->id]['matches']++;
            $table[$awayTeam->id]['matches']++;

            // Gols pró
            $table[$homeTeam->id]['goals_for'] += $match->home_score;
            $table[$awayTeam->id]['goals_for'] += $match->away_score;

            // Gols contra
            $table[$homeTeam->id]['goals_against'] += $match->away_score;
            $table[$awayTeam->id]['goals_against'] += $match->home_score;

            // Saldo
            $table[$homeTeam->id]['goal_difference'] =
                $table[$homeTeam->id]['goals_for']
                - $table[$homeTeam->id]['goals_against'];

            $table[$awayTeam->id]['goal_difference'] =
                $table[$awayTeam->id]['goals_for']
                - $table[$awayTeam->id]['goals_against'];

            // Resultado
            if ($match->home_score > $match->away_score) {

                // Vitória mandante
                $table[$homeTeam->id]['wins']++;
                $table[$homeTeam->id]['points'] += 3;

                $table[$awayTeam->id]['losses']++;

            } elseif ($match->home_score < $match->away_score) {

                // Vitória visitante
                $table[$awayTeam->id]['wins']++;
                $table[$awayTeam->id]['points'] += 3;

                $table[$homeTeam->id]['losses']++;

            } else {

                // Empate
                $table[$homeTeam->id]['draws']++;
                $table[$awayTeam->id]['draws']++;

                $table[$homeTeam->id]['points']++;
                $table[$awayTeam->id]['points']++;
            }
        }

        $table = array_values($table);

        usort($table, function ($a, $b) {

            // Pontos
            if ($a['points'] !== $b['points']) {
                return $b['points'] <=> $a['points'];
            }

            // Saldo
            if ($a['goal_difference'] !== $b['goal_difference']) {
                return $b['goal_difference'] <=> $a['goal_difference'];
            }

            // Gols pró
            return $b['goals_for'] <=> $a['goals_for'];
        });

        return response()->json([
            'competition' => $competition->name,
            'standings' => $table
        ]);
    }
}