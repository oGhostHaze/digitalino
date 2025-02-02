<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'category', 'difficulty'];

    // A game has many game sessions
    public function gameSessions() {
        return $this->hasMany(GameSession::class);
    }
}