<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioPublico extends Model
{
    protected $table = 'servicios_publicos';

    protected $fillable = [
        'tipo',
        'icono',
        'nombre',
        'horario',
        'email',
        'telefono',
        'descripcion',
        'activo',
        'orden',
        'latitud',
        'longitud',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
    ];

    // Tipos de servicio disponibles
    const TIPOS = [
        'colectivo' => 'Colectivo',
        'taxi' => 'Taxi',
        'remis' => 'Remis',
    ];

    // Scope para servicios activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
