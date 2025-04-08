<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rendeles extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rendelesek';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'teljes_osszeg',
        'statusz',
        'megjegyzes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'teljes_osszeg' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the products for the order.
     */
    public function termekek()
    {
        return $this->belongsToMany(Termek::class, 'rendeles_termek')
                    ->withPivot('mennyiseg', 'kezdo_datum', 'vegso_datum', 'ar')
                    ->withTimestamps();
    }

    /**
     * Check if the order can be cancelled.
     * 
     * @return bool
     */
    public function isCancellable()
    {
        return in_array($this->statusz, ['feldolgozas_alatt', 'visszaigazolva']);
    }
}