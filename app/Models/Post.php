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
    public function category()
    {
        return $this->belongsTo(Category::class, 'category');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
