<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kosar extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kosarak';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products in the cart.
     */
    public function termekek()
    {
        return $this->belongsToMany(Termek::class, 'kosar_termek')
                    ->withPivot('mennyiseg', 'kezdo_datum', 'vegso_datum')
                    ->withTimestamps();
    }

    /**
     * Calculate the total amount of the cart.
     * 
     * @return float
     */
    public function getTeljesOsszeg()
    {
        $osszeg = 0;

        foreach ($this->termekek as $termek) {
            $napokSzama = $this->calculateDaysBetween(
                $termek->pivot->kezdo_datum, 
                $termek->pivot->vegso_datum
            );
            $osszeg += $termek->ar * $termek->pivot->mennyiseg * $napokSzama;
        }

        return $osszeg;
    }

    /**
     * Calculate days between two dates.
     * 
     * @param string $kezdoDatum
     * @param string $vegsoDatum
     * @return int
     */
    private function calculateDaysBetween($kezdoDatum, $vegsoDatum)
    {
        $kezdo = new \DateTime($kezdoDatum);
        $vegso = new \DateTime($vegsoDatum);
        $diff = $kezdo->diff($vegso);
        
        // +1 hogy a kezdő napot is számoljuk
        return $diff->days + 1;
    }
}