<?php

use Illuminate\Support\Facades\Route;

// routes/web.php
Route::get('/', [BlogController::class, 'index'])->name('blog.index');
Route::get('/post/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category}', [BlogController::class, 'category'])->name('blog.category');
