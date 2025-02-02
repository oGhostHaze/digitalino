<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Progress;
use App\Models\GameSession;
use App\Notifications\StudentPerformanceTrend;

class ProgressService
{
    public function updateProgress(Student $student)
    {
        $sessions = GameSession::where('student_id', $student->id)->get();

        if ($sessions->isEmpty()) {
            return; // No sessions yet
        }

        $totalGames = $sessions->count();
        $averageScore = $sessions->avg('score');
        $highestScore = $sessions->max('score');
        $lastPlayed = $sessions->max('created_at');

        Progress::updateOrCreate(
            ['student_id' => $student->id],
            [
                'total_games'   => $totalGames,
                'average_score' => $averageScore,
                'highest_score' => $highestScore,
                'last_played'   => $lastPlayed,
            ]
        );
        // Determine the trend
        $trend = $averageScore > 75 ? 'positive' : 'negative';

        // Notify the parent and teacher
        if ($student->parent) {
            $student->parent->notify(new StudentPerformanceTrend($student, $trend));
        }
        if ($student->teacher) {
            $student->teacher->notify(new StudentPerformanceTrend($student, $trend));
        }
    }
}