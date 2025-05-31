<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ImagenPublicacion;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'user_id',
        'zona_id',
        'titulo',
        'descripcion',
        'estado',
        'interes_trueque',
    ];

    protected $casts = [
        'interes_trueque' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function imagenes()
{
    return $this->hasMany(ImagenPublicacion::class);
}

}
