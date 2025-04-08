<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategoria;

class KategoriaController extends Controller
{
    public function index()
    {
        $kategoriak = Kategoria::all();
        return view('kategoriak.index', compact('kategoriak'));
    }
    
    public function show(Kategoria $kategoria)
    {
        $termekek = $kategoria->termekek()->paginate(12);
        return view('kategoriak.show', compact('kategoria', 'termekek'));
    }
}