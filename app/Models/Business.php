<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'negocios';

    protected $fillable = [
        'nombre',
        'slug',
        'direccion',
        'telefono',
        'descripcion',
        'logo',
        'horarios',
        'activo',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'business_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
