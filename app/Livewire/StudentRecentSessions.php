<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GameSession;

class StudentRecentSessions extends Component
{
    public $studentId;

    public function mount($studentId)
    {
        $this->studentId = $studentId;
    }

    public function render()
    {

        $recentSessions = GameSession::where('student_id', $this->studentId)
                          ->latest()
                          ->take(5)
                          ->get();
        return view('livewire.student-recent-sessions', ['recentSessions'=> $recentSessions]);
    }
}
