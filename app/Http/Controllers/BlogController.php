<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::published()
            ->with('category')
            ->latest('published_at')
            ->paginate(10);
            
        return view('blog.index', compact('posts'));
    }
    
    public function show(Post $post)
    {
        if (!$post->published) {
            abort(404);
        }
        
        return view('blog.show', compact('post'));
    }
    
    public function category(Category $category)
    {
        $posts = $category->posts()
            ->published()
            ->latest('published_at')
            ->paginate(10);
            
        return view('blog.category', compact('category', 'posts'));
    }
}
