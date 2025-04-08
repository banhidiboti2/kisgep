<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Termek;
use App\Models\Kategoria;
use App\Models\Rendeles;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $termekekSzama = Termek::count();
        $kategoriasSzama = Kategoria::count();
        $rendelesekSzama = Rendeles::count();
        $usersCount = User::count();
        
        $ujRendelesek = Rendeles::where('statusz', 'feldolgozas_alatt')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'termekekSzama', 
            'kategoriasSzama', 
            'rendelesekSzama', 
            'usersCount', 
            'ujRendelesek'
        ));
    }
}

