<div class="p-4 max-w-md mx-auto">
    <button
        onclick="window.history.back()"
        class="mb-4 px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 focus:outline-none">
        ⬅️ Back
    </button>
    <div class="p-4 max-w-md mx-auto bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-center">🐾 Count the Animals! 🐾</h2>

        @if ($gameOver)
            <div class="text-center">
                <p class="text-2xl font-bold text-green-500">Game Over!</p>
                <p>🎯 Score: {{ $score }} / {{ $maxQuestions }}</p>
                <p>❌ Mistakes: {{ $mistakes }}</p>
                <p>📊 Accuracy: {{ $this->calculateAccuracy }}%</p>
            </div>
        @else
            <div class="flex justify-center space-x-2 text-4xl">
                @foreach ($objectsToCount as $animal)
                    <span>{{ $animal }}</span>
                @endforeach
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                @foreach ($options as $option)
                    <button
                        wire:click="submitAnswer({{ $option }})"
                        class="px-4 py-2 bg-blue-300 rounded-md hover:bg-blue-400 focus:outline-none">
                        {{ $option }}
                    </button>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <p>Question: {{ $questionCount }} / {{ $maxQuestions }}</p>
                <p>Score: {{ $score }} | Mistakes: {{ $mistakes }} | Level: {{ $level }}</p>
            </div>
        @endif
    </div>
</div>
