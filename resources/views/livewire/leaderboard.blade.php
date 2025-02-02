<div class="max-w-lg mx-auto mt-6 bg-white p-4 rounded-lg shadow-lg">
    <h2 class="text-xl font-bold text-center">🏆 Student Leaderboard 🏆</h2>
    <ul class="mt-4">
        @foreach ($students as $index => $student)
            <li class="flex justify-between px-4 py-2 border-b">
                <span class="font-semibold">{{ $index + 1 }}. {{ $student->name }}</span>
                <span class="text-blue-600 font-bold">{{ $student->total_score }} pts</span>
            </li>
        @endforeach
    </ul>
</div>
