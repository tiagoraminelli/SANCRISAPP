<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmaciaHistorial extends Model
{
    protected $table = 'farmacias_historial'; // Cambia el nombre de la tabla si es necesario

    protected $fillable = [
        'farmacia_id',
        'fecha_turno',
    ];

    protected $casts = [
        'fecha_turno' => 'date',
    ];

    public function farmacia(): BelongsTo
    {
        return $this->belongsTo(FarmaciaTurno::class, 'farmacia_id');
    }
}
