<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Usuario
        User::create([
            'name' => 'Jhomar Caleb',
            'email' => 'cchicas@gmail.com',
            'password' => Hash::make('User2026'),
            'role' => 'Super Usuario',
        ]);

        // Gestor de Cobros
        User::create([
            'name' => 'Gestor de Cobros',
            'email' => 'gestor@gmail.com',
            'password' => Hash::make('User2026'),
            'role' => 'Gestor de Cobros',
        ]);

        // Cliente
        User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@gmail.com',
            'password' => Hash::make('User2026'),
            'role' => 'Cliente',
        ]);
    }
}