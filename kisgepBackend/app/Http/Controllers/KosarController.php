<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kosar;
use App\Models\KosarTermek;
use App\Models\Termek;
use Illuminate\Support\Facades\Auth;

class KosarController extends Controller
{
    public function index()
    {
        $kosar = $this->getOrCreateCart();
        $kosarTermekek = $kosar->termekek;
        
        return view('kosar.index', compact('kosarTermekek'));
    }
    
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'termek_id' => 'required|exists:termekek,id',
            'mennyiseg' => 'required|integer|min:1',
            'kezdo_datum' => 'required|date|after_or_equal:today',
            'vegso_datum' => 'required|date|after_or_equal:kezdo_datum',
        ]);
        
        $kosar = $this->getOrCreateCart();
        
        // Ellenőrizzük, hogy van-e már ilyen termék a kosárban
        $meglevoTermek = KosarTermek::where('kosar_id', $kosar->id)
            ->where('termek_id', $validated['termek_id'])
            ->first();
        
        if ($meglevoTermek) {
            // Ha már van ilyen termék, frissítjük a mennyiséget
            $meglevoTermek->update([
                'mennyiseg' => $meglevoTermek->mennyiseg + $validated['mennyiseg'],
                'kezdo_datum' => $validated['kezdo_datum'],
                'vegso_datum' => $validated['vegso_datum'],
            ]);
        } else {
            // Ha még nincs ilyen termék, hozzáadjuk a kosárhoz
            KosarTermek::create([
                'kosar_id' => $kosar->id,
                'termek_id' => $validated['termek_id'],
                'mennyiseg' => $validated['mennyiseg'],
                'kezdo_datum' => $validated['kezdo_datum'],
                'vegso_datum' => $validated['vegso_datum'],
            ]);
        }
        
        return redirect()->route('kosar.index')->with('success', 'Termék hozzáadva a kosárhoz!');
    }
    
    public function updateCart(Request $request)
    {
        $validated = $request->validate([
            'termek_id' => 'required|array',
            'termek_id.*' => 'exists:termekek,id',
            'mennyiseg' => 'required|array',
            'mennyiseg.*' => 'integer|min:1',
            'kezdo_datum' => 'required|array',
            'kezdo_datum.*' => 'date',
            'vegso_datum' => 'required|array',
            'vegso_datum.*' => 'date',
        ]);
        
        $kosar = $this->getOrCreateCart();
        
        foreach ($validated['termek_id'] as $index => $termekId) {
            KosarTermek::where('kosar_id', $kosar->id)
                ->where('termek_id', $termekId)
                ->update([
                    'mennyiseg' => $validated['mennyiseg'][$index],
                    'kezdo_datum' => $validated['kezdo_datum'][$index],
                    'vegso_datum' => $validated['vegso_datum'][$index],
                ]);
        }
        
        return redirect()->route('kosar.index')->with('success', 'Kosár sikeresen frissítve!');
    }
    
    public function removeFromCart($termekId)
    {
        $kosar = $this->getOrCreateCart();
        
        KosarTermek::where('kosar_id', $kosar->id)
            ->where('termek_id', $termekId)
            ->delete();
        
        return redirect()->route('kosar.index')->with('success', 'Termék törölve a kosárból!');
    }
    
    public function clearCart()
    {
        $kosar = $this->getOrCreateCart();
        
        KosarTermek::where('kosar_id', $kosar->id)->delete();
        
        return redirect()->route('kosar.index')->with('success', 'Kosár kiürítve!');
    }
    
    private function getOrCreateCart()
    {
        $user = Auth::user();
        
        $kosar = Kosar::firstOrCreate([
            'user_id' => $user->id
        ]);
        
        return $kosar;
    }
}
