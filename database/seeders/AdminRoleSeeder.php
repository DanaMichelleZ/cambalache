<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();

        if ($user) {
            $user->rol = 'admin';
            $user->save();
            echo "Usuario actualizado a rol admin.\n";
        } else {
            echo "No se encontró un usuario con ese email.\n";
        }
    }
}
