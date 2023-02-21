<?php

use App\Http\Controllers\CompetitionsController;
use App\Http\Controllers\PlayersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('players', PlayersController::class);
Route::apiResource('competitions', CompetitionsController::class);

Route::patch('competitions/{competition}/add/{player}', 'App\Http\Controllers\CompetitionsController@addPlayer');
Route::patch('competitions/{competition}/increment/{player}', 'App\Http\Controllers\CompetitionsController@incrementPlayerScore');
