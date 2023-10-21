<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'title',
        'meta_desc',
        'slug',
        'tag',
        'category',
        'cover',
        'body'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_post');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
