<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendelesTermek extends Model
{
    use HasFactory;
    
    protected $table = 'rendeles_termek';
    
    protected $fillable = [
        'rendeles_id',
        'termek_id',
        'rendeles_azonosito', 
        'mennyiseg',
        'kezdo_datum',
        'vegso_datum',
        'ar'
    ];
    

    public function rendeles()
    {
        return $this->belongsTo(Rendeles::class, 'rendeles_id');
    }
    
    public function termek()
    {
        return $this->belongsTo(Termek::class, 'termek_id');
    }
}