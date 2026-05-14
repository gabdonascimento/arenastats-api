<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MatchGameController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\StandingController;
use App\Http\Controllers\MatchEventController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\RoundController;

Route::apiResource('teams', TeamController::class);
Route::apiResource('players', PlayerController::class);
Route::apiResource('matches', MatchGameController::class);
Route::apiResource('competitions', CompetitionController::class);
Route::apiResource('match-events', MatchEventController::class)
    ->only(['index', 'store', 'show', 'destroy']);
Route::apiResource('rounds', RoundController::class)
    ->only(['index', 'store', 'show', 'destroy']);

Route::get(
    'standings/{competition}',
    [StandingController::class, 'index']
);

Route::get(
    'top-scorers/{competition}',
    [StatisticController::class, 'topScorers']
);

Route::get('matches/{match}/timeline', [MatchGameController::class, 'timeline']);
