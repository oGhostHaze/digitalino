@php
    $correctAnswer = (float)$questions[$currentQuestion]['correct_answer'];

    // Generate 3 unique wrong answers avoiding negative values
    $wrongAnswers = [];
    while (count($wrongAnswers) < 3) {
        $fakeAnswer = $correctAnswer + rand(0, 10); // Adjusted to avoid negative values
        if ($fakeAnswer !== $correctAnswer && !in_array($fakeAnswer, $wrongAnswers)) {
            $wrongAnswers[] = $fakeAnswer;
        }
    }

    // Merge correct answer with wrong answers, then shuffle
    $options = $wrongAnswers;
    $options[] = $correctAnswer;
    shuffle($options);
@endphp


<div class="p-4 max-w-md mx-auto">
    <button
        onclick="window.history.back()"
        class="mb-4 px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 focus:outline-none">
        ⬅️ Back
    </button>
    <div class="p-4 max-w-md mx-auto bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center">{{ $game->title }}</h2>
        @if (session()->has('message'))
            <div class="bg-green-300 text-green-800 p-2 rounded-md mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if ($gameOver)
            <div class="text-center">
                <p class="text-2xl font-bold text-green-500">Game Over!</p>
                <p>🎯 Score: {{ $score }} / {{ count($questions) }}</p>
                <p>❌ Mistakes: {{ $mistakes }}</p>
                <p>📊 Accuracy: {{ $this->calculateAccuracy }}%</p>
            </div>
        @else
            <div class="p-4 bg-blue-100 rounded-md">
                <p class="text-xl">{{ $questions[$currentQuestion]['question'] }}</p>
                <div class="flex space-x-2 mt-4">
                    @foreach ($options as $option)
                        <button wire:click="submitAnswer({{ $option }})"
                            class="px-4 py-2 bg-green-300 rounded-md hover:bg-green-400 focus:outline-none">
                            {{ $option }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="text-center text-gray-600">
                <p>Question {{ $currentQuestion + 1 }} of {{ count($questions) }}</p>
                <p class="text-red-500">Mistakes: {{ $mistakes }}</p>
                <p class="text-green-500">Completed Levels: {{ $completedLevel }}</p>
            </div>

            <button wire:click="endGame" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Submit Session
            </button>
        @endif
    </div>
</div>
