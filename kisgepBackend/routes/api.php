<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TermekController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendelesController;

// Public routes
Route::post('/rendeles/direct', [RendelesController::class, 'storeDirect']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/termekek', [TermekController::class, 'index']); // Public product listing
Route::middleware('auth:sanctum')->post('/orders', 'OrderController@store');

// Protected routes - require authentication
Route::middleware('auth:sanctum')->group(function () {
    // User profile route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Protected product routes (create, update, delete)
    Route::post('/termekek', [TermekController::class, 'store']);
    Route::put('/termekek/{termek}', [TermekController::class, 'update']);
    Route::delete('/termekek/{termek}', [TermekController::class, 'destroy']);
    
    // Add other protected routes here
});