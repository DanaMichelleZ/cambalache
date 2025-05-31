<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Zona;
use App\Models\Publicacion;
use App\Models\ImagenPublicacion;
use Illuminate\Support\Facades\Hash;

class PublicacionesSeeder extends Seeder
{
    public function run(): void
    {
        // Crear o reutilizar una zona de prueba
        $zona = Zona::firstOrCreate(['nombre' => 'Zona Test']);

        // Crear 3 usuarios de prueba
        $usuarios = User::factory()->count(3)->create([
            'password' => Hash::make('password'),
            'zona_id' => $zona->id,
        ]);

        foreach ($usuarios as $usuario) {
            // Crear 2 publicaciones por usuario
            for ($i = 1; $i <= 2; $i++) {
                $publicacion = Publicacion::create([
                    'user_id' => $usuario->id,
                    'zona_id' => $usuario->zona_id,
                    'titulo' => "Publicación de {$usuario->name} #{$i}",
                    'descripcion' => 'Esta es una publicación de prueba.',
                    'estado' => ['nuevo', 'usado', 'roto'][rand(0, 2)],
                    'interes_trueque' => ['libros', 'ropa', 'herramientas'],
                ]);

                // Usar imagen de prueba local
                ImagenPublicacion::create([
                    'publicacion_id' => $publicacion->id,
                    'ruta' => 'images/remera.png',
                ]);                
            }
        }
    }
}
