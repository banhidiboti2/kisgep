<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rendeles;
use App\Models\RendelesTermek;
use App\Models\Kosar;
use App\Models\KosarTermek;
use App\Models\Termek;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class RendelesController extends Controller
{
    
    public function store(Request $request)
    {
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
        
        $teljesOsszeg = 0;
        foreach ($kosar->termekek as $kosarTermek) {
            $napokSzama = (strtotime($kosarTermek->vegso_datum) - strtotime($kosarTermek->kezdo_datum)) / (60 * 60 * 24) + 1;
            $teljesOsszeg += $kosarTermek->termek->ar * $kosarTermek->mennyiseg * $napokSzama;
        }
        
        DB::beginTransaction();
        
        try {
            $rendelesAzonosito = $this->generateUniqueOrderIdentifier();
            
            $rendeles = Rendeles::create([
                'user_id' => Auth::id(),
                'teljes_osszeg' => $teljesOsszeg,
                'statusz' => 'feldolgozas_alatt',
                'megjegyzes' => $request->megjegyzes,
                'rendeles_azonosito' => $rendelesAzonosito,
            ]);
            
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
            $identifier = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
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
        $request->validate([
            'megjegyzes' => 'nullable|string|max:1000',
            'basket_items' => 'required|array',
            'email' => 'required|email',
        ]);

        $teljesOsszeg = 0;
        foreach ($request->basket_items as $item) {
            $napokSzama = (strtotime($item['vegso_datum']) - strtotime($item['kezdo_datum'])) / (60 * 60 * 24) + 1;
            $termek = \App\Models\Termek::findOrFail($item['termek_id']);
            $teljesOsszeg += $termek->ar * $item['mennyiseg'] * $napokSzama;
        }
        
        DB::beginTransaction();
        
        try {
            $rendelesAzonosito = $this->generateUniqueOrderIdentifier();
            
            $rendeles = new Rendeles();

            $userId = null;
            if (Auth::check()) {
                $userId = Auth::id();
            } elseif ($request->has('user_id') && !empty($request->user_id)) {
                $userId = $request->user_id;
            }

            $rendeles->user_id = $userId;
            $rendeles->email = $request->email; 
            $rendeles->teljes_osszeg = $teljesOsszeg + ($request->deposit_amount ?? 50000);
            $rendeles->statusz = 'feldolgozas_alatt';
            $rendeles->megjegyzes = $request->megjegyzes ?? '';
            $rendeles->rendeles_azonosito = $rendelesAzonosito;
            $rendeles->save();
            
            foreach ($request->basket_items as $item) {
                $termek = Termek::findOrFail($item['termek_id']);
                
                $napokSzama = (strtotime($item['vegso_datum']) - strtotime($item['kezdo_datum'])) / (60 * 60 * 24) + 1;
                $ar = $termek->ar * $napokSzama;
                
                $rendelesTermek = new RendelesTermek();
                $rendelesTermek->rendeles_id = $rendeles->id;
                $rendelesTermek->termek_id = $item['termek_id'];
                $rendelesTermek->mennyiseg = $item['mennyiseg'];
                $rendelesTermek->kezdo_datum = $item['kezdo_datum'];
                $rendelesTermek->vegso_datum = $item['vegso_datum'];
                $rendelesTermek->ar = $ar;
                
                $rendelesTermek->rendeles_azonosito = $rendelesAzonosito;
                
                $rendelesTermek->save();
            }
            
            DB::commit();
            
            try {
                \Log::info('E-mail küldés megkezdése: ' . $request->email);
                config(['mail.default' => 'smtp']);
                config(['mail.mailers.smtp.host' => 'smtp.gmail.com']);
                config(['mail.mailers.smtp.port' => 587]);
                config(['mail.mailers.smtp.encryption' => 'tls']);
                config(['mail.mailers.smtp.username' => 'abkisgep@gmail.com']);
                config(['mail.mailers.smtp.password' => 'idmrpkfkkqcxfmkm']);
                
                \Log::info('Mail konfiguráció: ' . json_encode(config('mail')));
                
                Mail::raw("Rendelés visszaigazolás\n\nKöszönjük rendelését! Az Ön rendelésének azonosítója: " . 
                    $rendelesAzonosito . "\n\nÜdvözlettel,\nA&B Kisgép Kölcsönző", function ($message) use ($request, $rendelesAzonosito) {
                    $message->to($request->email)
                            ->from('abkisgep@gmail.com', 'A&B Kisgép Kölcsönző')
                            ->subject('Rendelés visszaigazolás - #' . $rendelesAzonosito);
                });
                
                \Log::info('E-mail sikeresen elküldve');
            } catch (\Exception $e) {
                \Log::error('E-mail küldési hiba: ' . $e->getMessage());
                \Log::error('Részletes hiba: ' . $e->getTraceAsString());
            }
            
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


