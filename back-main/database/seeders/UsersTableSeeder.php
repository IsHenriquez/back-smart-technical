<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'activo' => 1,
            'tipo_usuario' => 1,
            'name' => 'Gabriel',
            'apellido_paterno' => 'Lagos',
            'email' => 'gabriel@smart_technical.com',
            'password' => Hash::make('Gato2023'),
        ]);

        User::create([
            'activo' => 1,
            'tipo_usuario' => 1,
            'name' => 'Isadora',
            'apellido_paterno' => 'Henriquez',
            'email' => 'sadora@smart_technical.com',
            'password' => Hash::make('Isadora2023'),
        ]);

    }
}
