<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = ['stream_url','video_url','forum_url'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
