<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::created(function (Comment $comment) {
            // 1. Reply Notification (if it's a reply)
            if ($comment->parent_id && $comment->parent) {
                // Notify the author of the parent comment
                if ($comment->parent->user_id !== $comment->user_id) {
                    Notification::create([
                        'user_id'    => $comment->parent->user_id,
                        'actor_id'   => $comment->user_id,
                        'type'       => 'reply',
                        'recipe_id'  => $comment->recipe_id,
                        'comment_id' => $comment->id,
                        'is_read'    => false,
                    ]);
                }
            } 
            // 2. Base Comment Notification (if it's a top-level comment)
            else if ($comment->recipe && $comment->recipe->user_id !== $comment->user_id) {
                Notification::create([
                    'user_id'    => $comment->recipe->user_id,
                    'actor_id'   => $comment->user_id,
                    'type'       => 'comment',
                    'recipe_id'  => $comment->recipe_id,
                    'comment_id' => $comment->id,
                    'is_read'    => false,
                ]);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
