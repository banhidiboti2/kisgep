<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Termek;
use App\Models\Kategoria;

class ApiController extends Controller
{
    public function termekek()
    {
        $termekek = Termek::all();
        return response()->json($termekek);
    }
    
    public function kategoriak()
    {
        $kategoriak = Kategoria::all();
        return response()->json($kategoriak);
    }
    
    public function termekekByKategoria(Kategoria $kategoria)
    {
        $termekek = Termek::where('kategoria_id', $kategoria->id)->get();
        return response()->json($termekek);
    }
    
    public function nepszeruTermekek()
    {
        $termekek = Termek::orderBy('nepszeruseg', 'desc')->take(10)->get();
        return response()->json($termekek);
    }
}