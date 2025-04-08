<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoria extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kategoriak';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nev',
        'leiras',
        'kep',
    ];

    /**
     * Get the products for the category.
     */
    public function termekek()
    {
        return $this->hasMany(Termek::class, 'kategoria_id');
    }
}