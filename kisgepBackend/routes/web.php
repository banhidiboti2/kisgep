<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// E-mail küldés teszt
Route::get('/mail-test', function () {
    try {
        Mail::raw('Teszt e-mail a kisgép kölcsönzőből', function ($message) {
            $message->to('abkisgep@gmail.com')
                    ->subject('E-mail küldési teszt');
        });
        
        return "E-mail elküldve! Ellenőrizd a postaládát.";
    } catch (\Exception $e) {
        return "Hiba történt: " . $e->getMessage();
    }
});