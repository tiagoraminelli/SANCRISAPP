<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'rutas';

    protected $fillable = [
        'transporte_id',
        'origen',
        'destino',
        'duracion_estimada',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relación con transporte
    public function transporte()
    {
        return $this->belongsTo(Transporte::class);
    }

    // Relación con horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
