<div class="p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold">Teacher Dashboard</h1>
    <p class="mb-4">Welcome, {{ auth()->user()->name }}! Manage students and track their progress here.</p>

    @foreach ($notifications as $notification)
        <div class="bg-yellow-100 p-4 rounded mb-2">
            {{ $notification->data['message'] }}
        </div>
    @endforeach

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($students as $student)
            <div class="p-4 bg-blue-100 rounded-md">
                <h2 class="font-semibold text-lg">{{ $student->name }}</h2>
                <p>Games Played: {{ $student->gameSessions->count() }}</p>
                <p>Average Score: {{ $student->progress->average_score ?? 'N/A' }}</p>
                <button wire:click="viewStudent({{ $student->id }})"
                    class="mt-2 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                    View Progress
                </button>
            </div>
        @endforeach
    </div>
    <livewire:leaderboard />

</div>
