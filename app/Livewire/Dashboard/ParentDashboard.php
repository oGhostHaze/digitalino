<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ParentDashboard extends Component
{
    public $students;
    public function mount()
    {
        $this->students = Auth::user()->children()->with('progress', 'gameSessions')->get();
    }

    public function render()
    {
        $notifications = auth()->user()->notifications;

        return view('livewire.dashboard.parent-dashboard', ['notifications'=> $notifications]);
    }
}