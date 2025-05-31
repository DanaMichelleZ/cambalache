<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Support\Facades\Auth;

class InicioController extends Controller
{
    public function index()
    {
        $publicaciones = Publicacion::with(['user.zona', 'imagenes'])->latest()->get();

        return inertia('Inicio', [
            'publicaciones' => $publicaciones,
        ]);
    }
}
