<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'actor_id', 'type', 'recipe_id', 'comment_id', 'contact_message_id', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function contactMessage()
    {
        return $this->belongsTo(ContactMessage::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function getMessageAttribute(): string
    {
        $actor  = $this->actor?->name ?? 'Quelqu\'un';
        $recipe = $this->recipe?->name ?? 'votre recette';

        return match($this->type) {
            'like'    => "{$actor} a aimé votre recette « {$recipe} »",
            'comment' => "{$actor} a commenté votre recette « {$recipe} »",
            'reply'   => "{$actor} a répondu à votre commentaire sur « {$recipe} »",
            'contact_reply' => "{$actor} a répondu à votre message de contact",
            default   => "{$actor} a interagi avec votre recette « {$recipe} »",
        };
    }

    public function getIconAttribute(): string
    {
        return match($this->type) {
            'like'    => 'fa-heart text-danger',
            'comment' => 'fa-comment text-primary',
            'reply'   => 'fa-reply text-success',
            'contact_reply' => 'fa-envelope-open-text text-success',
            default   => 'fa-bell',
        };
    }
}
