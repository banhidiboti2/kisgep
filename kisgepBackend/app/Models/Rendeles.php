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
    protected $table = 'rendeles';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'email',  
        'teljes_osszeg',
        'statusz',
        'megjegyzes',
        'rendeles_azonosito'
    ];
    
    /**
     * Get the items for the order.
     */
    public function termekek()
    {
        return $this->hasMany(RendelesTermek::class, 'rendeles_id');
    }
    
    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}