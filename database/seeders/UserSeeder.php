<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tworzymy administratora
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // hasło to 'password'
            'role' => 'administrator',
        ]);

        // Tworzymy zwykłego użytkownika
        User::create([
            'name' => 'Jan Kowalski',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // hasło to 'password'
            'role' => 'user',
        ]);
    }
}
