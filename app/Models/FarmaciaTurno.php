<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FarmaciaTurno extends Model
{
    protected $table = 'farmacias_turno'; // Cambia el nombre de la tabla si es necesario

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'latitud',
        'longitud',
        'horario_apertura',
        'horario_cierre',
        'descripcion',
        'logo',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'horario_apertura' => 'datetime:H:i',
        'horario_cierre' => 'datetime:H:i',
    ];

    // Relación con rotación
    public function rotaciones(): HasMany
    {
        return $this->hasMany(FarmaciaRotacion::class, 'farmacia_id');
    }

    // Relación con historial
    public function historial(): HasMany
    {
        return $this->hasMany(FarmaciaHistorial::class, 'farmacia_id');
    }

    // Verificar si está de turno hoy
    public function estaDeTurnoHoy(): bool
    {
        $hoy = now();
        $diaSemana = $hoy->dayOfWeek; // 1=Lunes, 7=Domingo en Carbon

        // Ajustar para que Lunes=1, Domingo=7
        $diaCarbon = $hoy->dayOfWeekIso; // 1=Lunes, 7=Domingo

        return $this->rotaciones()
            ->where('activo', true)
            ->where(function ($query) use ($diaCarbon, $hoy) {
                $query->where(function ($q) use ($diaCarbon) {
                    $q->where('dia_semana', $diaCarbon)
                        ->where(function ($sq) {
                            $sq->whereNull('semana_mes')
                                ->orWhere('semana_mes', ceil(now()->day / 7));
                        });
                })->orWhere('fecha_especifica', $hoy->toDateString());
            })
            ->exists();
    }

    // Scope para farmacias activas
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }

    // Scope para farmacia de turno hoy
    public function scopeDeTurnoHoy($query)
    {
        $hoy = now();
        $diaSemana = $hoy->dayOfWeekIso;
        $semanaMes = ceil($hoy->day / 7);

        return $query->whereHas('rotaciones', function ($q) use ($diaSemana, $semanaMes, $hoy) {
            $q->where('activo', true)
                ->where(function ($sq) use ($diaSemana, $semanaMes, $hoy) {
                    $sq->where('dia_semana', $diaSemana)
                        ->where(function ($ssq) use ($semanaMes) {
                            $ssq->whereNull('semana_mes')
                                ->orWhere('semana_mes', $semanaMes);
                        })
                        ->orWhere('fecha_especifica', $hoy->toDateString());
                });
        });
    }

    /**
     * Check if pharmacy is on duty on a specific date
     */
    public function estaDeTurnoEnFecha($fecha)
    {
        $diaSemana = $fecha->dayOfWeekIso; // 1=Lunes, 7=Domingo
        $semanaMes = ceil($fecha->day / 7);

        return $this->rotaciones()
            ->where('activo', true)
            ->where(function ($query) use ($diaSemana, $semanaMes, $fecha) {
                $query->where(function ($q) use ($diaSemana, $semanaMes) {
                    $q->where('dia_semana', $diaSemana)
                        ->where(function ($sq) use ($semanaMes) {
                            $sq->whereNull('semana_mes')
                                ->orWhere('semana_mes', $semanaMes);
                        });
                })->orWhere('fecha_especifica', $fecha->toDateString());
            })
            ->exists();
    }
}
