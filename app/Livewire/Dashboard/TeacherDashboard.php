<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TeacherDashboard extends Component
{
    public $students;

    public function mount()
    {
        $this->students = Auth::user()->students()->with('progress', 'gameSessions')->get();
    }

    public function viewStudent($studentId)
    {
        return redirect()->route('teacher.student.progress', ['studentId' => $studentId]);
    }

    public function render()
    {
        $notifications = auth()->user()->notifications;

        return view('livewire.dashboard.teacher-dashboard', ['notifications'=> $notifications]);
    }
}