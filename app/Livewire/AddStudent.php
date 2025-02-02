<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddStudent extends Component
{
    use LivewireAlert;

    public $name, $age, $parent_id, $teacher_id, $parents = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'age' => 'required|numeric',
        'parent_id' => 'required|exists:users,id',
    ];

    public function saveStudent()
    {
        $this->validate();

        $account = User::create([
            'email' => Str::slug($this->name).'@student.com',
            'name' => $this->name,
            'username' => Str::slug($this->name),
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        Student::create([
            'name' => $this->name,
            'age' => $this->age,
            'parent_id' => $this->parent_id,
            'teacher_id' => auth()->id(),
            'student_id' => $account->id,
        ]);

        $this->alert('success', 'Student added successfully!');
        $this->reset(); // Clear input fields after saving
        $this->dispatch('studentAdded'); // Notify other components
    }

    public function render()
    {
        return view('livewire.add-student');
    }

    public function mount()
    {
        $this->parents = User::where('role', 'parent')->get();
    }
}