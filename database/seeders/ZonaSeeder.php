<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zona;
use Illuminate\Support\Str;

class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barriosCABA = [
            'Agronomía', 'Almagro', 'Balvanera', 'Barracas', 'Belgrano', 'Boedo',
            'Caballito', 'Chacarita', 'Coghlan', 'Colegiales', 'Constitución',
            'Flores', 'Floresta', 'La Boca', 'La Paternal', 'Liniers', 'Mataderos',
            'Monserrat', 'Monte Castro', 'Nueva Pompeya', 'Núñez', 'Palermo',
            'Parque Avellaneda', 'Parque Chacabuco', 'Parque Chas', 'Parque Patricios',
            'Puerto Madero', 'Recoleta', 'Retiro', 'Saavedra', 'San Cristóbal',
            'San Nicolás', 'San Telmo', 'Vélez Sársfield', 'Versalles',
            'Villa Crespo', 'Villa del Parque', 'Villa Devoto', 'Villa General Mitre',
            'Villa Lugano', 'Villa Luro', 'Villa Ortúzar', 'Villa Pueyrredón',
            'Villa Real', 'Villa Riachuelo', 'Villa Santa Rita', 'Villa Soldati',
            'Villa Urquiza'
        ];

        $partidosAMBA = [
            'Almirante Brown', 'Avellaneda', 'Berazategui', 'Berisso', 'Brandsen',
            'Cañuelas', 'Campana', 'Ensenada', 'Escobar', 'Esteban Echeverría',
            'Ezeiza', 'Florencio Varela', 'Gral. San Martín', 'Hurlingham', 'Ituzaingó',
            'José C. Paz', 'La Matanza', 'Lanús', 'Lomas de Zamora', 'Luján',
            'Malvinas Argentinas', 'Marcos Paz', 'Merlo', 'Moreno', 'Morón',
            'Pilar', 'Presidente Perón', 'Quilmes', 'San Fernando', 'San Isidro',
            'San Miguel', 'San Vicente', 'Tigre', 'Tres de Febrero', 'Vicente López',
            'Zárate'
        ];

        foreach ($barriosCABA as $barrio) {
            Zona::updateOrCreate(
                ['nombre' => $barrio, 'tipo' => 'CABA'],
                ['slug' => Str::slug($barrio)]
            );
        }

        foreach ($partidosAMBA as $partido) {
            Zona::updateOrCreate(
                ['nombre' => $partido, 'tipo' => 'AMBA'],
                ['slug' => Str::slug($partido)]
            );
        }
    }
}
