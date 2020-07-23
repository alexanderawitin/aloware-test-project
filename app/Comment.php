<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = ['user_name', 'body'];

    public function commentable() {
        return $this->morphTo();
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id')->with([
            'replies' => function (HasMany $query) {
                $query->orderBy('created_at', 'asc');
            },
            'replies.parent'
        ]);
    }

    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
