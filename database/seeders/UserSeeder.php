<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Super Usuario
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            ['email' => 'cchicas@gmail.com'],
            [
                'name' => 'Jhomar Caleb',
                'password' => Hash::make('User2026'),
                'role' => 'Super Usuario',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Gestor de Cobros
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            ['email' => 'owen@gmail.com'],
            [
                'name' => 'Owen Torres',
                'password' => Hash::make('1234'),
                'role' => 'Gestor de Cobros',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Cliente
        |--------------------------------------------------------------------------
        | Primero creamos el registro en la tabla clientes.
        */

        $cliente = Cliente::firstOrCreate(
            ['documento_identidad' => '01234567-8'],
            [
                'nombres' => 'Katherine Andrea',
                'apellidos' => 'Ramos Carranza',
                'telefono' => '70000000',
                'correo' => 'andrea@gmail.com',
                'direccion' => 'Zacatecoluca',
                'estado' => 'Activo',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Usuario del Cliente
        |--------------------------------------------------------------------------
        | Vinculamos el usuario con el cliente mediante cliente_id.
        */

        User::firstOrCreate(
            ['email' => 'andrea@gmail.com'],
            [
                'name' => 'Katherine Andrea Ramos Carranza',
                'password' => Hash::make('1234'),
                'role' => 'Cliente',
                'cliente_id' => $cliente->id,
            ]
        );
    }
}