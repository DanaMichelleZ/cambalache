<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Zona;

class ProfileController extends Controller
{
    public function edit(Request $request): Response
    {
        $user = $request->user()->load('zona');

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail,
            'status' => session('status'),
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'zona_nombre' => $user->zona?->nombre,
                'tipo_zona' => $user->zona?->tipo,
                'partido' => $user->partido,
            ],
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'zona_tipo' => 'required|in:CABA,AMBA',
            'partido' => 'required|string|max:255',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->partido = $validated['partido'];

        // Buscar zona por nombre y tipo
        $zona = Zona::where('nombre', $validated['partido'])
            ->where('tipo', $validated['zona_tipo'])
            ->first();

        if ($zona) {
            $user->zona_id = $zona->id;
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }
}
