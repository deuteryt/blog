<!-- resources/views/blog/category.blade.php -->
@extends('layouts.app')

@section('title', 'Kategoria: ' . $category->name)

@section('content')
<h1 style="margin-bottom: 1rem; color: #2563eb;">Kategoria: {{ $category->name }}</h1>

<div class="posts-container">
    @forelse($posts as $post)
        <article class="post-item">
            <h2 class="post-title">
                <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
            </h2>
            <div class="post-meta">
                <span>{{ $post->published_at->format('d.m.Y') }}</span>
            </div>
            <p class="post-excerpt">{{ $post->excerpt }}</p>
        </article>
    @empty
        <div class="post-item">
            <p>Brak postów w tej kategorii.</p>
        </div>
    @endforelse
</div>

{{ $posts->links() }}
@endsection