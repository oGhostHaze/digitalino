<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameSession extends Model
{

    use HasFactory;

    protected $fillable = ['student_id', 'game_id', 'score', 'mistakes_count', 'completed_level', 'accuracy', 'duration', 'difficulty'];

    // A game session belongs to a student
    public function student() {
        return $this->belongsTo(Student::class);
    }

    // A game session belongs to a game
    public function game() {
        return $this->belongsTo(Game::class);
    }
}
