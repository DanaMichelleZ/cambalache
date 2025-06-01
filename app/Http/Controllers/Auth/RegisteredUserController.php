<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Zona;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Muestra la vista de registro con las zonas disponibles.
     */
    public function create(): Response
    {
        $zonas = Zona::orderBy('tipo')->orderBy('nombre')->get(['id', 'nombre', 'tipo']);

        return Inertia::render('Auth/Register', [
            'zonas' => $zonas,
        ]);
    }

    /**
     * Registra al nuevo usuario con zona, partido y rol.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'zona_id' => 'required|exists:zonas,id',
            'partido' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'zona_id' => $request->zona_id,
            'partido' => $request->partido,
            'rol' => 'usuario',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('inicio');
    }
}
