<div class="p-4 max-w-md mx-auto">
    <button
        onclick="window.history.back()"
        class="mb-4 px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400 focus:outline-none">
        ⬅️ Back
    </button>
    <div class="p-4 max-w-md mx-auto bg-white rounded-lg shadow-md">
        <h2 class="text-xl font-bold text-center mb-4">🧩 Completing Patterns Game</h2>
        @if (session()->has('game_over'))
            <div class="bg-yellow-300 p-4 rounded-md text-center">
                {{ session('game_over') }}
                <button wire:click="resetGame" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-md">Play Again</button>
            </div>
        @else
            @if (session('success'))
                <div class="bg-green-200 text-green-800 p-2 rounded mb-2">{{ session('success') }}</div>
            @elseif (session('error'))
                <div class="bg-red-200 text-red-800 p-2 rounded mb-2">{{ session('error') }}</div>
            @endif

            <div class="flex justify-center space-x-2 text-4xl mb-4">
                @foreach ($patterns[$currentPattern]['sequence'] as $item)
                    <div class="w-12 h-12 flex items-center justify-center">{{ $item }}</div>
                @endforeach
            </div>

            <div class="flex justify-center space-x-4">
                @foreach ($patterns[$currentPattern]['options'] as $option)
                    <div
                        class="cursor-pointer text-4xl border-2 border-gray-300 p-2 rounded-md hover:bg-gray-100 transition"
                        draggable="true"
                        ondragstart="event.dataTransfer.setData('text/plain', '{{ $option }}')"
                    >
                        {{ $option }}
                    </div>
                @endforeach
            </div>

            <div
                class="mt-4 border-2 border-dashed border-gray-400 rounded-md p-4 text-center text-2xl text-gray-500"
                ondrop="handleDrop(event)"
                ondragover="event.preventDefault()"
            >
                Drop Here ❓
            </div>
        @endif

        <script>
            function handleDrop(event) {
                event.preventDefault();
                const selected = event.dataTransfer.getData("text");
                Livewire.dispatch('checkAnswer', { data: selected });  // Corrected to an object
            }

        </script>
    </div>

</div>
