<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    public function comments() {
        return $this->morphMany(Comment::class, 'commentable')->with([
            'replies' => function (HasMany $query) {
                $query->orderBy('created_at', 'asc');
            },
            'replies.parent'
        ]);
    }
}
