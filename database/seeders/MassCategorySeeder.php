<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class MassCategorySeeder extends Seeder
{
    public function run()
    {
        // Wyczyść tabele
        Category::truncate();
        
        $categories = [
            'Technologia' => [
                'PHP', 'JavaScript', 'Python', 'Java', 'C++', 'Laravel', 'React', 'Vue.js', 
                'Node.js', 'Angular', 'Docker', 'Kubernetes', 'DevOps', 'AI/ML', 'Blockchain'
            ],
            'Lifestyle' => [
                'Podróże', 'Zdrowie', 'Fitness', 'Gotowanie', 'Moda', 'Uroda', 'Dom i ogród',
                'Rozwój osobisty', 'Minimalizm', 'Ekologia'
            ],
            'Biznes' => [
                'Marketing', 'E-commerce', 'Startup', 'Inwestycje', 'Kryptowaluty', 
                'Nieruchomości', 'Freelancing', 'Przedsiębiorczość', 'Finanse osobiste',
                'Księgowość', 'HR', 'Management'
            ],
            'Nauka' => [
                'Matematyka', 'Fizyka', 'Chemia', 'Biologia', 'Historia', 'Geografia',
                'Astronomia', 'Medycyna', 'Psychologia', 'Socjologia'
            ],
            'Sztuka i Kultura' => [
                'Malarstwo', 'Fotografia', 'Film', 'Literatura', 'Teatr',
                'Taniec', 'Rzeźba', 'Design', 'Architektura'
            ],
            'Sport' => [
                'Piłka nożna', 'Koszykówka', 'Tenis', 'Bieganie', 'Siłownia', 'Joga',
                'Pływanie', 'Kolarstwo', 'Wspinaczka', 'Sporty zimowe'
            ],
            'Hobby' => [
                'Gry wideo', 'Książki', 'Filmy', 'Muzyka', 'Kolekcjonowanie', 'DIY',
                'Rękodzieło', 'Majsterkowanie', 'Ogrodnictwo', 'Akwarystyka'
            ],
            'Motoryzacja' => [
                'Samochody osobowe', 'Motocykle', 'Samochody ciężarowe', 'Elektryki',
                'Tuning', 'Wyścigi', 'Części zamienne', 'Serwis', 'Jazdy testowe'
            ]
        ];
        
        foreach ($categories as $parentName => $subcategories) {
            echo "Tworzę kategorię: {$parentName}\n";
            
            $parent = Category::create([
                'name' => $parentName,
                'slug' => Str::slug($parentName)
            ]);
            
            foreach ($subcategories as $subcategoryName) {
                Category::create([
                    'name' => $subcategoryName,
                    'slug' => Str::slug($subcategoryName),
                    'parent_id' => $parent->id
                ]);
            }
        }
        
        echo "Utworzono " . Category::whereNull('parent_id')->count() . " kategorii głównych\n";
        echo "Utworzono " . Category::whereNotNull('parent_id')->count() . " podkategorii\n";
    }
}
