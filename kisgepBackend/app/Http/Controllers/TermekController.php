<?php

namespace App\Http\Controllers;

use App\Models\Termek;
use Illuminate\Http\Request;

class TermekController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $termekek = Termek::all()->map(function($termek) {
            // Kép base64 formátumba alakítása
            $kepBase64 = base64_encode($termek->kep);
            
            return [
                'id' => $termek->id,
                'nev' => $termek->nev,
                'leiras' => $termek->leiras,
                'ar' => $termek->ar,
                'keszlet' => $termek->keszlet,
                'image_url' => 'data:image/jpeg;base64,' . $kepBase64
            ];
        });
        
        return response()->json($termekek);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $termek = Termek::findOrFail($id);
        $kepBase64 = base64_encode($termek->kep);
        
        return response()->json([
            'id' => $termek->id,
            'nev' => $termek->nev,
            'leiras' => $termek->leiras,
            'ar' => $termek->ar,
            'keszlet' => $termek->keszlet,
            'image_url' => 'data:image/jpeg;base64,' . $kepBase64
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}

