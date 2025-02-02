<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\GameSession;

class StudentDashboard extends Component
{
    public function render()
    {
        $student = auth()->user()->student;
        $progress = $student->progress ?? [];

        return view('livewire.dashboard.student-dashboard', compact('progress'));
    }
}
