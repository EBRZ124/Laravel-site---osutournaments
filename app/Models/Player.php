<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name','country'];

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class);
    }
}
