<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Rozpoczynam seedowanie bazy danych...');
        
        // Najpierw kategorie
        $this->command->info('Tworzę kategorie...');
        $this->call(MassCategorySeeder::class);
        
        // Potem posty (wymagają kategorii)
        $this->command->info('Tworzę posty...');
        $this->call(MassPostSeeder::class);
        
        $this->command->info('Seedowanie zakończone pomyślnie!');
    }
}
