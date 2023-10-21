<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'title',
        'image',
        'slug',
        'description',
        'level'
    ];

    public function post()
    {
        return $this->hasMany(Post::class, 'id_tutorial');
    }
}
