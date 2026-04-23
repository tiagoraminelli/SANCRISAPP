<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmaciaRotacion extends Model
{
    protected $table = 'farmacias_rotacion'; // Cambia el nombre de la tabla

    protected $fillable = [
        'farmacia_id',
        'dia_semana',
        'semana_mes',
        'fecha_especifica',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_especifica' => 'date',
    ];

    // Días de la semana
    const DIAS = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ];

    // Semanas del mes
    const SEMANAS = [
        1 => 'Primera semana',
        2 => 'Segunda semana',
        3 => 'Tercera semana',
        4 => 'Cuarta semana',
    ];

    public function farmacia(): BelongsTo
    {
        return $this->belongsTo(FarmaciaTurno::class, 'farmacia_id');
    }

    public function getDiaNombreAttribute(): string
    {
        return self::DIAS[$this->dia_semana] ?? 'Desconocido';
    }

    public function getSemanaNombreAttribute(): string
    {
        if (is_null($this->semana_mes)) {
            return 'Todas las semanas';
        }
        return self::SEMANAS[$this->semana_mes] ?? 'Semana ' . $this->semana_mes;
    }
}
