<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Crea un utente senza ruolo
        User::firstOrCreate(
            ['email' => 'user@aulab.it'],
            [
                'name' => 'Steven Manson (User)',
                'password' => Hash::make('password'),
                'is_writer' => false,
                'is_revisor' => false,
                'is_admin' => false,
            ]
        );

        // Crea un utente con ruolo writer
        User::firstOrCreate([
            ['email' => 'writer@aulab.it'],
            [
                'name' => "Daria Richardson (Writer)",
                'password' => Hash::make('password'),
                'is_writer' => true,
                'is_revisor' => false,
                'is_admin' => false,
            ]
        ]);

        // Crea un utente con ruolo revisor
        User::firstOrCreate([
            ['email' => 'revisor@aulab.it'],
            [
                'name' => "Antony Delgado (Revisor)",
                'password' => Hash::make('password'),
                'is_writer' => false,
                'is_revisor' => true,
                'is_admin' => false
            ]
        ]);

        // Crea un amministratore
        User::firstOrCreate([
            ['email' => 'admin@aulab.it'],
            [
                'name' => 'Steve Lorren (Admin)',
                'password' => Hash::make('password'),
                'is_writer' => false,
                'is_revisor' => false,
                'is_admin' => true
            ]
        ]);

        // Crea un super amministratore con tutti i ruoli
        User::firstOrCreate([
            ['email' => 'super.admin@aulab.it'],
            [
                'name' => "Mario Bianchi (Super admin)",
                'password' => Hash::make('password'),
                'is_writer' => true,
                'is_revisor' => true,
                'is_admin' => true
            ]
        ]);
        // Crea un super amministratore con tutti i ruoli
        User::firstOrCreate([
            ['email' => 'kvrs@gmail.com'],
            [
                'name' => "Kevin Ross (Attacker)",
                'password' => Hash::make('password'),
                'is_writer' => false,
                'is_revisor' => false,
                'is_admin' => false
            ]
        ]);
    }
}
