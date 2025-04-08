<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Termek;
use App\Models\Kategoria;
use Illuminate\Support\Facades\Storage;

class AdminTermekController extends Controller
{
    public function index()
    {
        $termekek = Termek::paginate(15);
        return view('admin.termekek.index', compact('termekek'));
    }
    
    public function create()
    {
        $kategoriak = Kategoria::all();
        return view('admin.termekek.create', compact('kategoriak'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nev' => 'required|string|max:255',
            'leiras' => 'nullable|string',
            'ar' => 'required|numeric|min:0',
            'kep' => 'required|image|max:2048',
            'kategoria_id' => 'required|exists:kategoriak,id',
            'keszlet' => 'required|integer|min:0',
        ]);
        
        if ($request->hasFile('kep')) {
            $kepUtvonal = $request->file('kep')->store('termekek', 'public');
            $validated['kep'] = $kepUtvonal;
        }
        
        Termek::create($validated);
        
        return redirect()->route('admin.termekek.index')->with('success', 'Termék sikeresen létrehozva!');
    }
    
    public function show(Termek $termek)
    {
        return view('admin.termekek.show', compact('termek'));
    }
    
    public function edit(Termek $termek)
    {
        $kategoriak = Kategoria::all();
        return view('admin.termekek.edit', compact('termek', 'kategoriak'));
    }
    
    public function update(Request $request, Termek $termek)
    {
        $validated = $request->validate([
            'nev' => 'required|string|max:255',
            'leiras' => 'nullable|string',
            'ar' => 'required|numeric|min:0',
            'kep' => 'nullable|image|max:2048',
            'kategoria_id' => 'required|exists:kategoriak,id',
            'keszlet' => 'required|integer|min:0',
        ]);
        
        if ($request->hasFile('kep')) {
            // Régi kép törlése
            if ($termek->kep) {
                Storage::disk('public')->delete($termek->kep);
            }
            
            $kepUtvonal = $request->file('kep')->store('termekek', 'public');
            $validated['kep'] = $kepUtvonal;
        }
        
        $termek->update($validated);
        
        return redirect()->route('admin.termekek.index')->with('success', 'Termék sikeresen frissítve!');
    }
    
    public function destroy(Termek $termek)
    {
        // Kép törlése
        if ($termek->kep) {
            Storage::disk('public')->delete($termek->kep);
        }
        
        $termek->delete();
        
        return redirect()->route('admin.termekek.index')->with('success', 'Termék sikeresen törölve!');
    }
}

