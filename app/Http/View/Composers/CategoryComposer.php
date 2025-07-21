<?php
// app/Http/View/Composers/CategoryComposer.php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Category;

class CategoryComposer
{
    public function compose(View $view)
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();
            
        $view->with('categories', $categories);
    }
}