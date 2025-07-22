<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MassPostSeeder extends Seeder
{
    public function run()
    {
        // Wyczyść tabele
        Post::truncate();
        
        $categories = Category::whereNotNull('parent_id')->get();
        
        if ($categories->isEmpty()) {
            echo "Brak kategorii! Uruchom najpierw MassCategorySeeder\n";
            return;
        }
        
        // Przygotuj przykładowe tytuły i treści
        $titleTemplates = [
            'Technologia' => [
                'Jak rozpocząć przygodę z {}',
                'Przewodnik po {} dla początkujących',
                '10 najlepszych praktyk w {}',
                'Przyszłość {} w 2025 roku',
                'Dlaczego warto uczyć się {}',
                'Top 5 narzędzi do {}',
                '{} vs inne technologie - porównanie',
                'Jak zostać ekspertem {}',
                'Najczęstsze błędy w {}',
                'Trendy w {} na najbliższe lata'
            ],
            'Lifestyle' => [
                'Sekrety sukcesu w {}',
                'Jak {} zmienia życie na lepsze',
                'Przewodnik po {} dla każdego',
                '7 mitów o {} które warto obalić',
                'Dlaczego {} jest ważne dla zdrowia',
                'Jak zacząć przygodę z {}',
                'Najlepsze sposoby na {}',
                '{} - trend czy konieczność?',
                'Moja historia z {}',
                'Jak {} wpływa na samopoczucie'
            ],
            'Biznes' => [
                'Jak odnieść sukces w {}',
                'Pierwsze kroki w {}',
                'Błędy których należy unikać w {}',
                'Przyszłość {} w Polsce',
                'Najlepsze strategie {}',
                'Jak zacząć biznes w {}',
                'Trendy w {} na 2025',
                'Inwestowanie w {} - czy warto?',
                'Przewodnik po {} dla początkujących',
                'Sekrety profesjonalistów {}'
            ],
            'Sport' => [
                'Trening {} dla początkujących',
                'Jak poprawić wyniki w {}',
                'Dieta dla uprawiających {}',
                'Najlepszy sprzęt do {}',
                'Historia {} w Polsce',
                'Techniki {} dla zaawansowanych',
                'Jak unikać kontuzji w {}',
                'Psychologia {} - mentalność zwycięzcy',
                'Trenerzy {} - jak wybrać najlepszego',
                'Motywacja w {} - jak się zmotywować'
            ],
            'Domyślne' => [
                'Wszystko co musisz wiedzieć o {}',
                'Kompletny przewodnik po {}',
                'Jak {} zmienia nasz świat',
                'Przyszłość {} - co nas czeka',
                'Najważniejsze fakty o {}',
                'Dlaczego {} jest tak ważne',
                'Historia {} w pigułce',
                'Mity i prawdy o {}',
                'Jak wybrać najlepsze {}',
                'Sekretne triki {}'
            ]
        ];
        
        $excerptTemplates = [
            'W tym artykule dowiesz się wszystkiego o {}. Przedstawiamy najważniejsze informacje, które pomogą Ci zrozumieć ten temat.',
            'Kompleksowy przewodnik po {}. Odkryj sekrety, które znają tylko eksperci w tej dziedzinie.',
            'Czy zastanawiałeś się kiedyś nad {}? Ten artykuł rozwinie wszystkie Twoje wątpliwości i da praktyczne wskazówki.',
            'Poznaj fascynujący świat {}. Dzielimy się najnowszymi trendami i sprawdzonymi metodami.',
            'Eksperckie spojrzenie na {}. Praktyczne porady i wskazówki dla każdego, niezależnie od poziomu zaawansowania.',
            'Wprowadzenie do {} - wszystko co musisz wiedzieć na start. Proste wyjaśnienia skomplikowanych zagadnień.',
            'Najważniejsze trendy w {} w 2025 roku. Analiza ekspertów i prognozy na przyszłość.',
            'Jak {} może zmienić Twoje życie? Poznaj realne korzyści i sposoby ich osiągnięcia.'
        ];
        
        // Generuj posty
        $postsToGenerate = 500; // Zmień na ile chcesz postów
        $batchSize = 50;
        
        echo "Generuję {$postsToGenerate} postów...\n";
        
        for ($batch = 0; $batch < ceil($postsToGenerate / $batchSize); $batch++) {
            $posts = [];
            $currentBatchSize = min($batchSize, $postsToGenerate - ($batch * $batchSize));
            
            for ($i = 0; $i < $currentBatchSize; $i++) {
                $category = $categories->random();
                $parentCategory = $category->parent;
                
                // Wybierz szablon tytułu na podstawie kategorii nadrzędnej
                $templates = $titleTemplates[$parentCategory->name] ?? $titleTemplates['Domyślne'];
                $titleTemplate = collect($templates)->random();
                $title = str_replace('{}', $category->name, $titleTemplate);
                
                // Generuj excerpt
                $excerptTemplate = collect($excerptTemplates)->random();
                $excerpt = str_replace('{}', $category->name, $excerptTemplate);
                
                // Generuj treść
                $content = $this->generateContent($category->name, $parentCategory->name);
                
                // Losowa data publikacji (ostatnie 6 miesięcy)
                $publishedAt = Carbon::now()
                    ->subDays(rand(0, 180))
                    ->subHours(rand(0, 23))
                    ->subMinutes(rand(0, 59));
                
                $posts[] = [
                    'title' => $title,
                    'slug' => Str::slug($title) . '-' . rand(1000, 9999), // Dodaj random żeby uniknąć duplikatów
                    'excerpt' => $excerpt,
                    'content' => $content,
                    'category_id' => $category->id,
                    'published' => rand(0, 10) > 1, // 90% postów opublikowanych
                    'published_at' => $publishedAt,
                    'created_at' => $publishedAt,
                    'updated_at' => $publishedAt,
                ];
            }
            
            // Wstaw batch
            Post::insert($posts);
            echo "Utworzono batch " . ($batch + 1) . " (" . count($posts) . " postów)\n";
        }
        
        echo "\nPodsumowanie:\n";
        echo "Utworzono łącznie: " . Post::count() . " postów\n";
        echo "Opublikowanych: " . Post::where('published', true)->count() . "\n";
        echo "Nieopublikowanych: " . Post::where('published', false)->count() . "\n";
    }
    
    private function generateContent($categoryName, $parentCategoryName)
    {
        $paragraphs = [
            "W dzisiejszym artykule zagłębimy się w fascynujący świat {$categoryName}. Ta dziedzina {$parentCategoryName} oferuje niezliczone możliwości rozwoju i nauki.",
            
            "Historia {$categoryName} sięga wielu lat wstecz. Przez ten czas ewoluowała i dostosowywała się do zmieniających się potrzeb użytkowników.",
            
            "Obecnie {$categoryName} jest jednym z najszybciej rozwijających się obszarów w kategorii {$parentCategoryName}. Eksperci przewidują dalszy wzrost popularności.",
            
            "Aby w pełni wykorzystać potencjał {$categoryName}, warto poznać najnowsze trendy i najlepsze praktyki w tej dziedzinie.",
            
            "Wielu początkujących zadaje sobie pytanie: od czego zacząć naukę {$categoryName}? Odpowiedź nie jest jednoznaczna, ale istnieje kilka sprawdzonych metod.",
            
            "Pierwszym krokiem jest zrozumienie podstawowych koncepcji {$categoryName}. Bez solidnych fundamentów trudno będzie rozwijać bardziej zaawansowane umiejętności.",
            
            "Praktyczne zastosowanie {$categoryName} można zaobserwować w wielu dziedzinach życia. Od prostych codziennych zadań po skomplikowane projekty biznesowe.",
            
            "Inwestycja w rozwój umiejętności związanych z {$categoryName} może przynieść wymierne korzyści zarówno w życiu osobistym jak i zawodowym.",
            
            "Społeczność {$categoryName} jest bardzo aktywna i pomocna. Warto nawiązywać kontakty i uczestniczyć w wydarzeniach branżowych.",
            
            "Na koniec warto pamiętać, że {$categoryName} to obszar w ciągłym rozwoju. Regularne śledzenie nowości i trendów jest kluczem do sukcesu.",
            
            "Podsumowując, {$categoryName} oferuje ogromne możliwości dla każdego, kto jest gotowy poświęcić czas na naukę i rozwój w tej dziedzinie."
        ];
        
        // Wybierz losowe paragrafy (3-7)
        $selectedParagraphs = collect($paragraphs)
            ->random(rand(3, 7))
            ->implode("\n\n");
            
        return $selectedParagraphs;
    }
}
