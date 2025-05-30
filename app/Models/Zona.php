<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'slug',
    ];

    /**
     * Relación: una zona tiene muchos usuarios.
     */
    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}
