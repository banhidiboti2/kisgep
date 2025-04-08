<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class KosarTermek extends Pivot
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kosar_termek';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kosar_id',
        'termek_id',
        'mennyiseg',
        'kezdo_datum',
        'vegso_datum',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'kezdo_datum' => 'date',
        'vegso_datum' => 'date',
    ];

    /**
     * Get the shopping cart that owns the cart item.
     */
    public function kosar()
    {
        return $this->belongsTo(Kosar::class);
    }

    /**
     * Get the product that the cart item belongs to.
     */
    public function termek()
    {
        return $this->belongsTo(Termek::class);
    }
}