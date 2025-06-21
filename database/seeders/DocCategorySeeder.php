<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    \App\Models\DocCategory::create(['name' => 'BHP']);
    \App\Models\DocCategory::create(['name' => 'Instrukcja']);
    \App\Models\DocCategory::create(['name' => 'Procedura']);
    \App\Models\DocCategory::create(['name' => 'Regulamin']);
    }
}
