<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'teacher_id', 'name', 'age', 'avatar', 'student_id'];

    public function account() {
        return $this->belongsTo(User::class, 'student_id');
    }

    // A student belongs to a parent
    public function parent() {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // A student belongs to a teacher
    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // A student has many game sessions
    public function gameSessions() {
        return $this->hasMany(GameSession::class)->latest();
    }

    // A student has progress tracking
    public function progress() {
        return $this->hasOne(Progress::class);
    }

    // A student has many teachers through pivot table
    public function assignedTeachers() {
        return $this->belongsToMany(User::class, 'teacher_student', 'student_id', 'teacher_id');
    }

    public static function leaderboard()
    {
        return self::select('students.id', 'students.name')
            ->join('game_sessions', 'students.id', '=', 'game_sessions.student_id')
            ->selectRaw('SUM(game_sessions.score) as total_score, AVG(game_sessions.accuracy) as avg_accuracy')
            ->groupBy('students.id', 'students.name')
            ->orderByDesc('total_score')
            ->limit(10) // Show top 10 students
            ->get();
    }

}