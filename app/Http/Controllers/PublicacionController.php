<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use App\Models\ImagenPublicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PublicacionController extends Controller
{
    public function create()
    {
        $zona = Auth::user()->zona;
    
        $tipoZona = null;
        if ($zona && in_array($zona->tipo, ['AMBA', 'CABA'])) {
            $tipoZona = $zona->tipo;
        }
    
        return Inertia::render('Publicaciones/Create', [
            'userZona' => $tipoZona,
            'userPartido' => $zona?->nombre,
        ]);
    }
    
    
    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:nuevo,usado,roto',
            'interes_trueque' => 'nullable|array',
            'zonaGeneral' => 'required|string|in:CABA,AMBA',
            'partido' => 'required|string|max:255',
            'localidad' => 'required|string|max:255',
            'imagenes.*' => 'image|max:2048',
        ]);

        $publicacion = Publicacion::create([
            'user_id' => Auth::id(),
            'zona_id' => Auth::user()->zona_id,
            'zona' => $data['zonaGeneral'],
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'] ?? null,
            'estado' => $data['estado'],
            'interes_trueque' => $data['interes_trueque'] ?? [],
            'partido' => $data['partido'],
            'localidad' => $data['localidad'],
        ]);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $ruta = $imagen->store('publicaciones', 'public');

                ImagenPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'ruta' => $ruta,
                ]);
            }
        }

        return redirect()->route('inicio')->with('success', 'Publicación creada correctamente.');
    }


    public function index()
    {
        $publicaciones = Publicacion::with(['imagenes', 'user.zona'])
            ->latest()
            ->take(20)
            ->get();

        return Inertia::render('Inicio', [
            'publicaciones' => $publicaciones,
        ]);
    }


    public function show($id)
    {
        $publicacion = Publicacion::with(['imagenes', 'user.zona'])->findOrFail($id);

        return Inertia::render('Publicaciones/Show', [
            'publicacion' => $publicacion,
        ]);
    }
}
