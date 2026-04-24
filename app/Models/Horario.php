<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'ruta_id',
        'hora_salida',
        'hora_llegada',
        'dias',
        'notas',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'hora_salida' => 'datetime:H:i',
        'hora_llegada' => 'datetime:H:i',
    ];

    // Relación con ruta
    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }
}
