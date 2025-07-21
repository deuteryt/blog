<!-- resources/views/blog/show.blade.php -->
@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="posts-container">
    <article class="post-item">
        <h1 class="post-title">{{ $post->title }}</h1>
        <div class="post-meta">
            <span>{{ $post->published_at->format('d.m.Y') }}</span> |
            <span>{{ $post->category->name }}</span>
        </div>
        <div class="post-content">
            {!! nl2br(e($post->content)) !!}
        </div>
    </article>
</div>

<div style="margin-top: 2rem;">
    <a href="{{ route('blog.index') }}" style="color: #2563eb; text-decoration: none;">
        ← Powrót do listy postów
    </a>
</div>
@endsection