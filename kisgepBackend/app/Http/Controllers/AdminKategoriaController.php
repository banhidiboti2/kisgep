<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategoria;
use Illuminate\Support\Facades\Storage;

class AdminKategoriaController extends Controller
{
    public function index()
    {
        $kategoriak = Kategoria::paginate(15);
        return view('admin.kategoriak.index', compact('kategoriak'));
    }
    
    public function create()
    {
        return view('admin.kategoriak.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nev' => 'required|string|max:255',
            'leiras' => 'nullable|string',
            'kep' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('kep')) {
            $kepUtvonal = $request->file('kep')->store('kategoriak', 'public');
            $validated['kep'] = $kepUtvonal;
        }
        
        Kategoria::create($validated);
        
        return redirect()->route('admin.kategoriak.index')->with('success', 'Kategória sikeresen létrehozva!');
    }
    
    public function show(Kategoria $kategoria)
    {
        return view('admin.kategoriak.show', compact('kategoria'));
    }
    
    public function edit(Kategoria $kategoria)
    {
        return view('admin.kategoriak.edit', compact('kategoria'));
    }
    
    public function update(Request $request, Kategoria $kategoria)
    {
        $validated = $request->validate([
            'nev' => 'required|string|max:255',
            'leiras' => 'nullable|string',
            'kep' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('kep')) {
            // Régi kép törlése
            if ($kategoria->kep) {
                Storage::disk('public')->delete($kategoria->kep);
            }
            
            $kepUtvonal = $request->file('kep')->store('kategoriak', 'public');
            $validated['kep'] = $kepUtvonal;
        }
        
        $kategoria->update($validated);
        
        return redirect()->route('admin.kategoriak.index')->with('success', 'Kategória sikeresen frissítve!');
    }
    
    public function destroy(Kategoria $kategoria)
    {
        // Ellenőrizzük, hogy vannak-e termékek a kategóriában
        if ($kategoria->termekek()->count() > 0) {
            return redirect()->route('admin.kategoriak.index')
                ->with('error', 'Nem törölhető a kategória, mert termékek tartoznak hozzá!');
        }
        
        // Kép törlése
        if ($kategoria->kep) {
            Storage::disk('public')->delete($kategoria->kep);
        }
        
        $kategoria->delete();
        
        return redirect()->route('admin.kategoriak.index')->with('success', 'Kategória sikeresen törölve!');
    }
}

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