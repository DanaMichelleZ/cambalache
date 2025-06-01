<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Zona;
use App\Models\Publicacion;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'zona_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación: un usuario pertenece a una zona.
     */
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    /**
     * Relación: un usuario tiene muchas publicaciones.
     */
    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }

    /**
     * Devuelve el nombre de la zona, si está relacionada.
     */
    public function getZonaNombreAttribute()
    {
        return $this->zona ? $this->zona->nombre : null;
    }
}
