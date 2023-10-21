<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyComment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'id_comment',
        'name',
        'author',
        'body'
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'id_comment');
    }
}
