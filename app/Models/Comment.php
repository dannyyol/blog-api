<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    use CommentableTrait;
    protected $table = 'comments';

    protected $fillable = [
        'fullname', 'email', 'body', 'photo'
    ];

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}