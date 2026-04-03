<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/',                    [GameController::class, 'index']);
Route::post('/start',              [GameController::class, 'start']);
Route::post('/answer/{game}',      [GameController::class, 'answer']);
Route::get('/history',             [GameController::class, 'history']);
