<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 
        'category_id', 'published', 'published_at'
    ];
    
    protected $casts = [
        'published_at' => 'datetime',
        'published' => 'boolean'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
