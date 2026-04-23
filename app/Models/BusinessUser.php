<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessUser extends Model
{
    protected $table = 'business_user';

    protected $fillable = [
        'user_id',
        'business_id',
        'role',
    ];

    // Relación con usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con negocio
    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
