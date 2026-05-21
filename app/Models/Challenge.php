<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'icon', 'points'];

    public function completions()
    {
        return $this->hasMany(ChallengeCompletion::class);
    }
}
