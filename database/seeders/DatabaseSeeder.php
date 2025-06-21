<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ta sekcja wywołuje inne seedery.
        // Upewniamy się, że każdy jest tu wymieniony tylko raz.
        $this->call([
            UserSeeder::class,
            DocCategorySeeder::class,
            ContactCategorySeeder::class,
        ]);
    }
}
