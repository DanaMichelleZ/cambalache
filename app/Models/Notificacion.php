<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'from_user_id',
        'publicacion_id',
        'mensaje',
        'leida',
    ];

    public function destinatario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function remitente()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }
}
