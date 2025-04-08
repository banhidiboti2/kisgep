<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termek extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'termekek';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nev',
        'ar',
        'kep',
        'kategoria_id',
        'keszlet',
        'nepszeruseg',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'ar' => 'decimal:2',
    ];

    /**
     * Get the category that owns the product.
     */
    public function kategoria()
    {
        return $this->belongsTo(Kategoria::class, 'kategoria_id');
    }

    /**
     * Get the orders for the product.
     */
    public function rendelesek()
    {
        return $this->belongsToMany(Rendeles::class, 'rendeles_termek')
                    ->withPivot('mennyiseg', 'kezdo_datum', 'vegso_datum', 'ar')
                    ->withTimestamps();
    }

    /**
     * Get the shopping carts for the product.
     */
    public function kosarak()
    {
        return $this->belongsToMany(Kosar::class, 'kosar_termek')
                    ->withPivot('mennyiseg', 'kezdo_datum', 'vegso_datum')
                    ->withTimestamps();
    }

    /**
     * Check if the product is available for the specified dates.
     *
     * @param  string  $kezdoDatum
     * @param  string  $vegsoDatum
     * @return bool
     */
    public function isAvailable($kezdoDatum, $vegsoDatum)
    {
        // Itt implementálhatod a dátum ellenőrzési logikát
        // Pl. megnézni, hogy adott időszakban elérhető-e a termék
        // a keszlet alapján
        return true;
    }
}