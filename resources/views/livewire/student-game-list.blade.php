<div class="p-4">
    <!-- Search & Filters -->
    <div class="flex space-x-2 mb-4">
        <input type="text" wire:model.lazy="search" placeholder="Search games..." class="p-2 border rounded w-full">

        <select wire:model.lazy="category" class="p-2 border rounded">
            <option value="">All Categories</option>
            <option value="counting">Counting</option>
            <option value="addition">Addition</option>
            <option value="subtraction">Subtraction</option>
            <option value="multiplication">Multiplication</option>
            <option value="division">Division</option>
            <option value="pattern">Pattern</option>
        </select>

        <select wire:model.lazy="difficulty" class="p-2 border rounded">
            <option value="">All Difficulties</option>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
    </div>

    <!-- Game List with Images -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($games as $game)
            <div class="p-4 bg-white shadow rounded-lg border border-gray-200 hover:shadow-lg transition">
                <!-- Cartoon Image -->
                <img
                    src="{{ $game->image ? asset('storage/' . $game->image) : asset('images/games/' . strtolower($game->category) . '.png') }}"
                    alt="{{ $game->title }}"
                    class="w-full h-40 object-cover rounded-md mb-2"
                >

                <!-- Game Info -->
                <h3 class="text-lg font-bold text-blue-700">{{ $game->title }}</h3>
                <p class="text-sm text-gray-500">{{ ucfirst($game->category) }} | {{ ucfirst($game->difficulty) }}</p>
                <p class="mt-1 text-gray-600">{{ $game->description }}</p>

                <!-- Play Button -->
                @switch($game->category)
                    @case('addition')
                    @case('subtraction')
                    @case('multiplication')
                    @case('division')
                        <a href="{{ route('student.game.play', $game->id) }}" class="mt-3 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Play Now 🚀
                        </a>
                    @break
                    @case('counting')
                        <a href="{{ route('student.game.play.count', $game->id) }}" class="mt-3 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Play Now 🚀
                        </a>
                    @break
                    @case('pattern')
                        <a href="{{ route('student.game.play.pattern', $game->id) }}" class="mt-3 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Play Now 🚀
                        </a>
                    @break
                    @default

                @endswitch
            </div>
        @endforeach

    <!-- Pagination -->
    <div class="mt-4">
        {{ $games->links() }}
    </div>
</div>
