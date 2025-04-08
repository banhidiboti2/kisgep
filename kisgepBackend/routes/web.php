<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TermekController;
use App\Http\Controllers\KategoriaController;
use App\Http\Controllers\KosarController;
use App\Http\Controllers\RendelesController;
use App\Http\Controllers\AuthController;


// Főoldal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Termékek
Route::get('/termekek', [TermekController::class, 'index'])->name('termekek.index');
Route::get('/termekek/{termek}', [TermekController::class, 'show'])->name('termekek.show');
Route::get('/termekek/kategoria/{kategoria}', [TermekController::class, 'byKategoria'])->name('termekek.kategoria');

// Kategóriák
Route::get('/kategoriak', [KategoriaController::class, 'index'])->name('kategoriak.index');
Route::get('/kategoriak/{kategoria}', [KategoriaController::class, 'show'])->name('kategoriak.show');

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

// Admin felület route-ok (admin jogosultsághoz kötve)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Termékek kezelése
    Route::resource('termekek', AdminTermekController::class);
    
    // Kategóriák kezelése
    Route::resource('kategoriak', AdminKategoriaController::class);
    
    // Rendelések kezelése
    Route::get('/rendelesek', [AdminRendelesController::class, 'index'])->name('admin.rendelesek.index');
    Route::get('/rendelesek/{rendeles}', [AdminRendelesController::class, 'show'])->name('admin.rendelesek.show');
    Route::put('/rendelesek/{rendeles}/statusz', [AdminRendelesController::class, 'updateStatus'])->name('admin.rendelesek.statusz');
    
    // Felhasználók kezelése
    Route::get('/felhasznalok', [AdminUserController::class, 'index'])->name('admin.felhasznalok.index');
    Route::get('/felhasznalok/{user}', [AdminUserController::class, 'show'])->name('admin.felhasznalok.show');
    Route::delete('/felhasznalok/{user}', [AdminUserController::class, 'destroy'])->name('admin.felhasznalok.delete');
});

/*
|--------------------------------------------------------------------------
| API Routes (opcionális)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {
    Route::get('/termekek', [ApiController::class, 'termekek']);
    Route::get('/kategoriak', [ApiController::class, 'kategoriak']);
    Route::get('/termekek/kategoria/{kategoria}', [ApiController::class, 'termekekByKategoria']);
    Route::get('/nepszeru-termekek', [ApiController::class, 'nepszeruTermekek']);
});