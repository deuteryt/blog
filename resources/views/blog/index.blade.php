<!-- resources/views/blog/index.blade.php -->
@extends('layouts.app')

@section('title', 'Blog - Strona główna')

@section('content')
<div class="posts-container">
    @forelse($posts as $post)
        <article class="post-item">
            <h2 class="post-title">
                <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
            </h2>
            <div class="post-meta">
                <span>{{ $post->published_at->format('d.m.Y') }}</span> |
                <span>{{ $post->category->name }}</span>
            </div>
            <p class="post-excerpt">{{ $post->excerpt }}</p>
        </article>
    @empty
        <div class="post-item">
            <p>Brak postów do wyświetlenia.</p>
        </div>
    @endforelse
</div>

{{ $posts->links() }}
@endsection