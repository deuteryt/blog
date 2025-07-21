<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $tech = Category::create([
            'name' => 'Technologia',
            'slug' => 'technologia'
        ]);
        
        Category::create([
            'name' => 'PHP',
            'slug' => 'php',
            'parent_id' => $tech->id
        ]);
        
        Category::create([
            'name' => 'JavaScript',
            'slug' => 'javascript',
            'parent_id' => $tech->id
        ]);
        
        Category::create([
            'name' => 'Lifestyle',
            'slug' => 'lifestyle'
        ]);
    }
}
