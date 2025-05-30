<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zona;

class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zonas = [
            ['nombre' => 'Palermo', 'tipo' => 'barrio', 'slug' => 'palermo'],
            ['nombre' => 'Almagro', 'tipo' => 'barrio', 'slug' => 'almagro'],
            ['nombre' => 'Caballito', 'tipo' => 'barrio', 'slug' => 'caballito'],
            ['nombre' => 'Recoleta', 'tipo' => 'barrio', 'slug' => 'recoleta'],
            ['nombre' => 'Villa Urquiza', 'tipo' => 'barrio', 'slug' => 'villa-urquiza'],
        ];

        foreach ($zonas as $zona) {
            Zona::create($zona);
        }
    }
}
