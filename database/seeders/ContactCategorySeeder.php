<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $categories = [
    'Urlopy i nieobecności', 'Wynagrodzenia i paski płacowe', 'Szkolenia i rozwój',
    'Benefity (karta sportowa, opieka medyczna)', 'Sprawy administracyjne (zaświadczenia)',
    'Problemy ze sprzętem IT', 'Dostęp do systemów', 'Awarie oprogramowania',
    'Wnioski o nowy sprzęt/oprogramowanie', 'Bezpieczeństwo IT (incydenty)',
    'Rekrutacja wewnętrzna', 'Proces onboardingu nowego pracownika', 'Proces offboardingu',
    'Ocena pracownicza', 'Zarządzanie celami i wynikami', 'Kultura organizacyjna i wartości',
    'Konflikty w zespole', 'Zgłoszenie naruszenia/nieprawidłowości', 'Pomysły i sugestie (innowacje)',
    'Organizacja podróży służbowej', 'Rozliczenie delegacji', 'Marketing i komunikacja wewnętrzna',
    'Organizacja eventów firmowych', 'Sprawy prawne i umowy', 'Inne'
    ];

    foreach ($categories as $category) {
    \App\Models\ContactCategory::create(['name' => $category]);
    }
    }
}
