<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rendeles;
use App\Models\RendelesTermek;
use App\Models\Kosar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RendelesController extends Controller
{
    public function index()
    {
        $rendelesek = Auth::user()->rendelesek()->orderBy('created_at', 'desc')->paginate(10);
        return view('rendelesek.index', compact('rendelesek'));
    }
    
    public function show(Rendeles $rendeles)
    {
        // Ellenőrizzük, hogy a bejelentkezett felhasználóhoz tartozik-e a rendelés
        if ($rendeles->user_id !== Auth::id()) {
            abort(403, 'Nem vagy jogosult megtekinteni ezt a rendelést.');
        }
        
        return view('rendelesek.show', compact('rendeles'));
    }
    
    public function create()
    {
        $kosar = Kosar::where('user_id', Auth::id())->first();
        
        if (!$kosar || $kosar->termekek->isEmpty()) {
            return redirect()->route('kosar.index')->with('error', 'A kosár üres, nem lehet rendelést létrehozni.');
        }
        
        return view('rendelesek.create', compact('kosar'));
    }
    
    public function store(Request $request)
    {
        $kosar = Kosar::where('user_id', Auth::id())->first();
        
        if (!$kosar || $kosar->termekek->isEmpty()) {
            return redirect()->route('kosar.index')->with('error', 'A kosár üres, nem lehet rendelést létrehozni.');
        }
        
        $request->validate([
            'megjegyzes' => 'nullable|string|max:1000',
        ]);
        
        // Teljes összeg kiszámítása
        $teljesOsszeg = 0;
        foreach ($kosar->termekek as $kosarTermek) {
            $napokSzama = (strtotime($kosarTermek->vegso_datum) - strtotime($kosarTermek->kezdo_datum)) / (60 * 60 * 24) + 1;
            $teljesOsszeg += $kosarTermek->termek->ar * $kosarTermek->mennyiseg * $napokSzama;
        }
        
        DB::beginTransaction();
        
        try {
            // Rendelés létrehozása
            $rendeles = Rendeles::create([
                'user_id' => Auth::id(),
                'teljes_osszeg' => $teljesOsszeg,
                'statusz' => 'feldolgozas_alatt',
                'megjegyzes' => $request->megjegyzes,
            ]);
            
            // Termékek átvitele a rendeléshez
            foreach ($kosar->termekek as $kosarTermek) {
                $napokSzama = (strtotime($kosarTermek->vegso_datum) - strtotime($kosarTermek->kezdo_datum)) / (60 * 60 * 24) + 1;
                $termekAr = $kosarTermek->termek->ar * $napokSzama;
                
                RendelesTermek::create([
                    'rendeles_id' => $rendeles->id,
                    'termek_id' => $kosarTermek->termek_id,
                    'mennyiseg' => $kosarTermek->mennyiseg,
                    'kezdo_datum' => $kosarTermek->kezdo_datum,
                    'vegso_datum' => $kosarTermek->vegso_datum,
                    'ar' => $termekAr,
                ]);
            }
            
            // Kosár kiürítése
            KosarTermek::where('kosar_id', $kosar->id)->delete();
            
            DB::commit();
            
            return redirect()->route('rendelesek.show', $rendeles->id)->with('success', 'Rendelésed sikeresen leadva!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kosar.index')->with('error', 'Hiba történt a rendelés feldolgozása során.');
        }
    }
}
