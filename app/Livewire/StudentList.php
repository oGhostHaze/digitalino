<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class StudentList extends Component
{

    use WithPagination;
    use LivewireAlert;

    public $search = '';
    public $studentId, $name, $age, $parent_id;
    public $editing = false;


    #[On("studentAdded")]
    public function refreshList()
    {
        $this->resetPage();
    }

    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        $this->studentId = $student->id;
        $this->name = $student->name;
        $this->age = $student->age;
        $this->parent_id = $student->parent_id;
        $this->editing = true;
    }

    public function updateStudent()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'age' => 'nullable|numeric',
            'parent_id' => 'required|exists:users,id',
        ]);

        Student::where('id', $this->studentId)->update([
            'name' => $this->name,
            'age' => $this->age,
            'parent_id' => $this->parent_id,
        ]);

        $this->alert('success', 'Student updated successfully!');
        $this->reset(['studentId', 'name', 'age', 'parent_id', 'editing']);
        $this->refreshList();
    }

    public function deleteStudent($id)
    {
        Student::findOrFail($id)->delete();
        $this->alert('success', 'Student deleted successfully!');
        $this->refreshList();
    }
    public function render()
    {
        $students = Student::paginate(10);
        return view('livewire.student-list', [
            'students' => Student::where('name', 'like', "%{$this->search}%")->paginate(5),
        ]);
    }

    #[Computed()]
    public function parents()
    {
        return User::where('role', 'parent')->get();
    }
}