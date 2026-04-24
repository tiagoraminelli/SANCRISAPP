<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
    protected $table = 'transportes';

    protected $fillable = [
        'nombre',
        'tipo',
        'logo',
        'telefono',
        'email',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relación con rutas
    public function rutas()
    {
        return $this->hasMany(Ruta::class);
    }

    // Tipos de transporte
    const TIPOS = [
        'colectivo' => 'Colectivo',
        'taxi' => 'Taxi',
        'remis' => 'Remis',
    ];
}
