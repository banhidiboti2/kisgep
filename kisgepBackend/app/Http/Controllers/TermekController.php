<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Termek;
use App\Models\Kategoria;

class TermekController extends Controller
{
    public function index()
    {
        $termekek = Termek::paginate(12);
        return view('termekek.index', compact('termekek'));
    }
    
    public function show(Termek $termek)
    {
        // Növeljük a termék népszerűségét minden megtekintéskor
        $termek->increment('nepszeruseg');
        
        return view('termekek.show', compact('termek'));
    }
    
    public function byKategoria(Kategoria $kategoria)
    {
        $termekek = Termek::where('kategoria_id', $kategoria->id)->paginate(12);
        return view('termekek.index', compact('termekek', 'kategoria'));
    }
}