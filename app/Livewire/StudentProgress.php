<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Student;
use Livewire\Component;
use App\Models\Progress;
use App\Models\GameSession;
use App\Exports\GameSessionsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentProgressExport;

class StudentProgress extends Component
{
    public $studentId;
    public $progress;
    public $student;
    public $dateRange = 'all';
    public $category = 'all';
    public $difficulty = 'all';

    protected $listeners = ['gameSessionUpdated' => 'loadProgress'];

    public function mount($studentId)
    {
        $this->studentId = $studentId;
        $this->loadProgress();
        $this->student = Student::with('progress', 'gameSessions')->findOrFail($studentId);
        $this->progress = $this->student->progress;
    }

    public function loadProgress()
    {
        $this->progress = Progress::where('student_id', $this->studentId)->first();
    }

    public function render()
    {
        $query = GameSession::where('student_id', $this->studentId);

        // Apply Date Range Filter
        if ($this->dateRange === 'last_7_days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($this->dateRange === 'this_month') {
            $query->whereMonth('created_at', Carbon::now()->month);
        }

        // Apply Category Filter
        if ($this->category !== 'all') {
            $query->whereHas('game', function ($q) {
                $q->where('category', $this->category);
            });
        }

        // Apply Difficulty Filter
        if ($this->difficulty !== 'all') {
            $query->where('difficulty', $this->difficulty);
        }

        $sessions = $query->latest()->get();

        $progressData = [
            'scores' => $sessions->pluck('score'),
            'accuracy' => $sessions->pluck('accuracy'),
            'labels' => $sessions->pluck('created_at')->map(function ($date) {
                return $date->format('M d');
            }),
        ];

        return view('livewire.student-progress', [
            'sessions'=> $sessions,
            'progressData' => $progressData,
        ]);
    }

// Export Student Progress
public function exportStudentProgress()
{
    return Excel::download(
        new StudentProgressExport($this->studentId),
        'student_progress.xlsx'
    );
}

// Export Game Sessions
public function exportGameSessions()
{
    return Excel::download(
        new GameSessionsExport($this->studentId),
        'game_sessions.xlsx'
    );
}
}