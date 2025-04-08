<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Termek;
use App\Models\Kategoria;

class HomeController extends Controller
{
    public function index()
    {
        // Eheti legnépszerűbb két termék lekérdezése
        $nepszeruTermekek = Termek::orderBy('nepszeruseg', 'desc')->take(2)->get();
        
        // Kategóriák betöltése
        $kategoriak = Kategoria::all();
        
        return view('home', compact('nepszeruTermekek', 'kategoriak'));
    }
}