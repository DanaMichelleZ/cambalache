<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Notificacion;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Prefetch opcional si no usás Vite con múltiples entradas
        Vite::prefetch(concurrency: 3);

        // Compartir datos de usuario y notificaciones con Inertia
        Inertia::share('auth', function () {
            $user = Auth::user();

            if (!$user) {
                return ['user' => null];
            }

            return [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'rol' => $user->rol,
                    'notificaciones_enviadas' => Notificacion::where('from_user_id', $user->id)
                        ->pluck('publicacion_id')
                        ->toArray(),
                ],
            ];
        });
    }
}
