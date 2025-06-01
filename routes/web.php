<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\NotificacionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Página de bienvenida pública
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Vista de inicio que muestra publicaciones públicas
Route::get('/inicio', [PublicacionController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('inicio');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Publicaciones
    Route::get('/publicaciones/crear', [PublicacionController::class, 'create'])->name('publicaciones.create');
    Route::post('/publicaciones', [PublicacionController::class, 'store'])->name('publicaciones.store');

    // Ruta de detalle de publicación
    Route::get('/publicaciones/{id}', [PublicacionController::class, 'show'])
        ->middleware(['auth', 'verified'])
        ->name('publicaciones.show');

    // Notificaciones
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones', [NotificacionController::class, 'store'])->name('notificaciones.store'); // 🆕 ESTA LÍNEA
});

require __DIR__.'/auth.php';
