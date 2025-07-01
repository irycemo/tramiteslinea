<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'clave' => 1,
            'name' => 'Enrique Robledo Camacho',
            'estado' => 'activo',
            'email' => 'enrique_j_@hotmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 2,
            'name' => 'Tomas Hernandez Cuellar',
            'estado' => 'activo',
            'email' => 'tomas.hernandez@plancartemorelia.edu.mx',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 3,
            'name' => 'Martin Cervantes Contreras',
            'estado' => 'activo',
            'email' => 'cervantes.martin@gmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 4,
            'name' => 'Mauricio Landa Herrera',
            'estado' => 'activo',
            'email' => 'mlanda64@hotmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 5,
            'name' => 'Salvador Sanchez Alvarez',
            'estado' => 'activo',
            'email' => 'ssacat@outlook.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 6,
            'name' => 'Saul Hernandez Castro',
            'estado' => 'activo',
            'email' => 'scastro@michoacan.gob.mx',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'clave' => 7,
            'name' => 'Sistema de Gestión Catastral',
            'estado' => 'activo',
            'email' => 'sgc@gmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Sistemas');

    }
}
