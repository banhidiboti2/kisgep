<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rendeles;

class AdminRendelesController extends Controller
{
    public function index()
    {
        $rendelesek = Rendeles::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.rendelesek.index', compact('rendelesek'));
    }
    
    public function show(Rendeles $rendeles)
    {
        return view('admin.rendelesek.show', compact('rendeles'));
    }
    
    public function updateStatus(Request $request, Rendeles $rendeles)
    {
        $request->validate([
            'statusz' => 'required|in:feldolgozas_alatt,visszaigazolva,kiadva,visszahozva,lezarva',
        ]);
        
        $rendeles->update([
            'statusz' => $request->statusz
        ]);
        
        return redirect()->route('admin.rendelesek.show', $rendeles->id)
            ->with('success', 'Rendelés státusza sikeresen frissítve!');
    }
}