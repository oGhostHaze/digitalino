<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Progress extends Model
{

    use HasFactory;

    protected $fillable = ['student_id', 'total_games', 'average_score', 'highest_score', 'last_played'];

    // Progress belongs to a student
    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function last_played() {
        return Carbon::parse($this->last_played);
    }

}