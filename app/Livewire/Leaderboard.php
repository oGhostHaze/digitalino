<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;

class Leaderboard extends Component
{
    public $students;

    public function mount()
    {
        $this->students = Student::leaderboard();
    }

    public function render()
    {
        return view('livewire.leaderboard', ['students' => $this->students]);
    }
}