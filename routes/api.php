<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*

Route::get('/users', [MainController::class, 'index']);
Route::post('/users', [MainController::class, 'store']);
Route::get('/users/{id}', [MainController::class, 'show']);
Route::put('/users/{id}', [MainController::class, 'update']);
Route::patch('/users/{id}', [MainController::class, 'update']);
Route::delete('/users/{id}', [MainController::class, 'destroy']);

*/

// Cria automaticamente todas as rotas acima
Route::apiResource('users', MainController::class);