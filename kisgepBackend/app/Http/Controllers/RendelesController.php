<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rendeles;
use App\Models\RendelesTermek;
use App\Models\Kosar;
use App\Models\KosarTermek; // Adding the missing import
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RendelesController extends Controller
{
    // ...existing code...
    
    public function store(Request $request)
    {
        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'A rendeléshez be kell jelentkezni.');
        }
        
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
            // 6 számjegyű egyedi rendelésazonosító generálása
            $rendelesAzonosito = $this->generateUniqueOrderIdentifier();
            
            // Rendelés létrehozása
            $rendeles = Rendeles::create([
                'user_id' => Auth::id(),
                'teljes_osszeg' => $teljesOsszeg,
                'statusz' => 'feldolgozas_alatt',
                'megjegyzes' => $request->megjegyzes,
                'rendeles_azonosito' => $rendelesAzonosito,
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
            
            return redirect()->route('rendeles.show', $rendeles->id)->with('success', 'Rendelésed sikeresen leadva! Rendelésazonosítód: ' . $rendelesAzonosito);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('kosar.index')->with('error', 'Hiba történt a rendelés feldolgozása során: ' . $e->getMessage());
        }
    }
    
    /**
     * 6 számjegyű egyedi rendelésazonosító generálása
     * 
     * @return string
     */
    private function generateUniqueOrderIdentifier()
    {
        $found = false;
        $identifier = '';
        
        while (!$found) {
            // 6 számjegyű azonosító generálása
            $identifier = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Ellenőrizzük, hogy létezik-e már ilyen azonosító
            $exists = Rendeles::where('rendeles_azonosito', $identifier)->exists();
            
            if (!$exists) {
                $found = true;
            }
        }
        
        return $identifier;
    }

    /**
     * Direct order creation from frontend basket
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDirect(Request $request)
    {
        // Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
        if (!Auth::check()) {
            return response()->json(['message' => 'A rendeléshez be kell jelentkezni.'], 401);
        }
        
        $request->validate([
            'megjegyzes' => 'nullable|string|max:1000',
            'basket_items' => 'required|array',
            'basket_items.*.termek_id' => 'required|exists:termekek,id',
            'basket_items.*.mennyiseg' => 'required|integer|min:1',
            'basket_items.*.kezdo_datum' => 'required|date',
            'basket_items.*.vegso_datum' => 'required|date|after_or_equal:basket_items.*.kezdo_datum',
        ]);
        
        // Teljes összeg kiszámítása
        $teljesOsszeg = 0;
        foreach ($request->basket_items as $item) {
            $napokSzama = (strtotime($item['vegso_datum']) - strtotime($item['kezdo_datum'])) / (60 * 60 * 24) + 1;
            $termek = \App\Models\Termek::findOrFail($item['termek_id']);
            $teljesOsszeg += $termek->ar * $item['mennyiseg'] * $napokSzama;
        }
        
        DB::beginTransaction();
        
        try {
            // 6 számjegyű egyedi rendelésazonosító generálása
            $rendelesAzonosito = $this->generateUniqueOrderIdentifier();
            
            // Rendelés létrehozása
            $rendeles = Rendeles::create([
                'user_id' => Auth::id(),
                'teljes_osszeg' => $teljesOsszeg,
                'statusz' => 'feldolgozas_alatt',
                'megjegyzes' => $request->megjegyzes,
                'rendeles_azonosito' => $rendelesAzonosito,
            ]);
            
            // Termékek hozzáadása a rendeléshez
            foreach ($request->basket_items as $item) {
                $napokSzama = (strtotime($item['vegso_datum']) - strtotime($item['kezdo_datum'])) / (60 * 60 * 24) + 1;
                $termek = \App\Models\Termek::findOrFail($item['termek_id']);
                $termekAr = $termek->ar * $napokSzama;
                
                RendelesTermek::create([
                    'rendeles_id' => $rendeles->id,
                    'termek_id' => $item['termek_id'],
                    'mennyiseg' => $item['mennyiseg'],
                    'kezdo_datum' => $item['kezdo_datum'],
                    'vegso_datum' => $item['vegso_datum'],
                    'ar' => $termekAr,
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'message' => 'Rendelésed sikeresen leadva!',
                'rendeles_id' => $rendeles->id,
                'rendeles_azonosito' => $rendelesAzonosito
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Hiba történt a rendelés feldolgozása során: ' . $e->getMessage()], 500);
        }
    }
}
