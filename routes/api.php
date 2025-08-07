<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::post('/users', [MainController::class, 'addUser']);
Route::get('/users', [MainController::class, 'getUsers']);
Route::get('/users/{id}', [MainController::class, 'getUser']);
Route::put('/users/{id}', [MainController::class, 'updateUser']);
Route::delete('/users/{id}', [MainController::class, 'deleteUser']);
