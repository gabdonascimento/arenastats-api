<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

Route::apiResource('teams', TeamController::class);