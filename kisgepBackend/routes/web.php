<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
// Főoldal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Termékek
Route::get('/termekek', [TermekController::class, 'index'])->name('termekek.index');
Route::get('/termekek/{termek}', [TermekController::class, 'show'])->name('termekek.show');
Route::get('/termekek/kategoria/{kategoria}', [TermekController::class, 'byKategoria'])->name('termekek.kategoria');


// Regisztráció és bejelentkezés
Route::get('/regisztracio', [AuthController::class, 'showRegistrationForm'])->name('regisztracio.form');
Route::post('/regisztracio', [AuthController::class, 'register'])->name('regisztracio.post');
Route::get('/bejelentkezes', [AuthController::class, 'showLoginForm'])->name('bejelentkezes.form');
Route::post('/bejelentkezes', [AuthController::class, 'login'])->name('bejelentkezes.post');
Route::post('/kijelentkezes', [AuthController::class, 'logout'])->name('kijelentkezes');

// Védett route-ok (csak bejelentkezett felhasználóknak)
Route::middleware(['auth'])->group(function () {
    // Profil
    Route::get('/profil', [AuthController::class, 'profil'])->name('profil');
    Route::put('/profil', [AuthController::class, 'updateProfil'])->name('profil.update');
    
    // Kosár
    Route::get('/kosar', [KosarController::class, 'index'])->name('kosar.index');
    Route::post('/kosar/hozzaad', [KosarController::class, 'addToCart'])->name('kosar.hozzaad');
    Route::put('/kosar/frissit', [KosarController::class, 'updateCart'])->name('kosar.frissit');
    Route::delete('/kosar/torles/{termek}', [KosarController::class, 'removeFromCart'])->name('kosar.torles');
    Route::delete('/kosar/urites', [KosarController::class, 'clearCart'])->name('kosar.urites');
    
    // Rendelés
    Route::get('/rendeles/create', [RendelesController::class, 'create'])->name('rendeles.create');
    Route::post('/rendeles', [RendelesController::class, 'store'])->name('rendeles.store');
    Route::get('/rendelesek', [RendelesController::class, 'index'])->name('rendelesek.index');
    Route::get('/rendelesek/{rendeles}', [RendelesController::class, 'show'])->name('rendelesek.show');
});




Route::prefix('api')->group(function () {
    Route::get('/termekek', [ApiController::class, 'termekek']);
    Route::get('/kategoriak', [ApiController::class, 'kategoriak']);
    Route::get('/termekek/kategoria/{kategoria}', [ApiController::class, 'termekekByKategoria']);
    Route::get('/nepszeru-termekek', [ApiController::class, 'nepszeruTermekek']);
});

*/