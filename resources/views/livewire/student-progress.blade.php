<div class="w-full mx-auto bg-white shadow-md rounded-lg p-6 space-y-4">
    <h2 class="text-2xl font-bold text-center text-blue-500">📈 Progress for {{ $student->name }}</h2>
    <div class="flex space-x-4">
        <button wire:click="exportStudentProgress"
            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
            <i class="fa-regular fa-file-excel"></i>
        </button>

        <button wire:click="exportGameSessions"
            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                <i class="fa-regular fa-file-pdf"></i>
        </button>
    </div>


    @if ($progress)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-center">
            <div class="bg-blue-100 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Total Games</p>
                <p class="text-xl font-bold text-blue-700">{{ $progress->total_games }}</p>
            </div>

            <div class="bg-green-100 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Average Score</p>
                <p class="text-xl font-bold text-green-700">{{ $progress->average_score }}</p>
            </div>

            <div class="bg-yellow-100 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Highest Score</p>
                <p class="text-xl font-bold text-yellow-700">{{ $progress->highest_score }}</p>
            </div>

            <div class="bg-yellow-100 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Overall Accuracy</p>
                <p class="text-xl font-bold text-yellow-700">{{ number_format($sessions->average('accuracy') ?? 0, 2) }}%</p>
            </div>

            <div class="bg-purple-100 p-4 rounded-lg">
                <p class="text-sm text-gray-500">Last Played</p>
                <p class="text-xl font-bold text-purple-700">
                    {{ $progress->last_played ? $progress->last_played()->format('M d, Y') : 'N/A' }}
                </p>
            </div>
        </div>
    @else
        <p class="text-center text-gray-500">No progress data available yet. Start playing to track your progress! 🎯</p>
    @endif
    <div class="p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Game Sessions</h1>
        <div class="grid grid-cols-2 md:grid-cols-3 space-x-4 mb-4">
            <!-- Date Range Filter -->
            <select wire:model.lazy="dateRange" class="border rounded px-3 py-2">
                <option value="all">All Time</option>
                <option value="last_7_days">Last 7 Days</option>
                <option value="this_month">This Month</option>

            </select>

            <!-- Category Filter -->
            <select wire:model.lazy="category" class="border rounded px-3 py-2">
                <option value="all">All Categories</option>
                <option value="counting">Counting</option>
                <option value="addition">Addition</option>
                <option value="subtraction">Subtraction</option>
<option value="multiplication">Multiplication</option>
<option value="division">Division</option>
                <option value="pattern">Pattern</option>
            </select>

            <!-- Difficulty Filter -->
            <select wire:model.lazy="difficulty" class="border rounded px-3 py-2">
                <option value="all">All Difficulties</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>

            </select>
        </div>
        <ul class="mt-4">
            @foreach ($sessions as $session)
                <li class="border p-2 mb-1 rounded">
                    Game: {{ $session->game->title }} |
                    Score: {{ $session->score }} |
                    Accuracy: {{ $session->accuracy }}%
                </li>
            @endforeach
        </ul>
    </div>
</div>


