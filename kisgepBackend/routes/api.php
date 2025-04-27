<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TermekController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendelesController;

Route::post('/rendeles/direct', [RendelesController::class, 'storeDirect']);
Route::post('/rendeles', [RendelesController::class, 'storeDirect']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/termekek', [TermekController::class, 'index']); 
Route::get('/termekek/{id}', [TermekController::class, 'show']);




Route::middleware('auth:sanctum')->post('/orders', [RendelesController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::post('/termekek', [TermekController::class, 'store']);
    Route::put('/termekek/{termek}', [TermekController::class, 'update']);
    Route::delete('/termekek/{termek}', [TermekController::class, 'destroy']);
    
});