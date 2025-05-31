<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenPublicacion extends Model
{
    use HasFactory;

    protected $table = 'imagen_publicaciones';

    protected $fillable = [
        'publicacion_id',
        'ruta',
    ];

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }
}
