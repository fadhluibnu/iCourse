<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'id_post',
        'body'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }
    public function ReplyComments()
    {
        return $this->hasMany(ReplyComment::class, 'id_comment');
    }
}
