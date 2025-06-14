<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'title',
        'description',
        'prize_pool',
        'competition_type',
        'tournament_type',
        'location',
    ];

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    public function matchUps()
    {
        return $this->hasMany(MatchUp::class);
    }

    public function sources()
    {
        return $this->hasMany(Source::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
