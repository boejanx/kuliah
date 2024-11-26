<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StuffController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stuffs', [StuffController::class, 'index']);
Route::get('/stuffs/create', [StuffController::class, 'create']);
Route::post('/stuffs/store', [StuffController::class, 'store']);
Route::get('/stuffs/{id}', [StuffController::class, 'show']);
Route::get('/stuffs/{id}/edit', [StuffController::class, 'edit']);
Route::put('/stuffs/update/{id}', [StuffController::class, 'update']);
Route::delete('/stuffs/delete/{id}', [StuffController::class, 'delete']);
