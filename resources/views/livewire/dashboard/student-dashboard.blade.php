<div class="p-6">
    <h1 class="text-2xl font-bold">Student Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}! Start playing and learning!</p>

    @livewire('student-progress', ['studentId' => Auth::user()->student->id])
</div>
