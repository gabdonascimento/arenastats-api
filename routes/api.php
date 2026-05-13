<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MatchGameController;
use App\Http\Controllers\CompetitionController;

Route::apiResource('teams', TeamController::class);
Route::apiResource('players', PlayerController::class);
Route::apiResource('matches', MatchGameController::class);
Route::apiResource('competitions', CompetitionController::class);
