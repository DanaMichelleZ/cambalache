<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificacionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'publicacion_id' => 'required|exists:publicaciones,id',
        ]);

        $yaExiste = Notificacion::where('from_user_id', Auth::id())
            ->where('publicacion_id', $request->publicacion_id)
            ->exists();

        if ($yaExiste) {
            return back()->with('success', 'Ya enviaste una solicitud para esta publicación.');
        }

        Notificacion::create([
            'user_id' => $request->user_id,
            'from_user_id' => Auth::id(),
            'publicacion_id' => $request->publicacion_id,
            'mensaje' => 'Te enviaron una solicitud de trueque.',
        ]);

        return back()->with('success', 'Solicitud enviada.');
    }

    public function index()
    {
        $notificaciones = Notificacion::with(['remitente', 'publicacion'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Notificaciones/Index', [
            'notificaciones' => $notificaciones,
        ]);
    }
}
