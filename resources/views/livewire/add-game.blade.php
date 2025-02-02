<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-semibold text-gray-700">Add New Game</h2>

    <form wire:submit.prevent="saveGame">
        <div class="mb-4">
            <label class="block text-gray-700">Title</label>
            <input type="text" wire:model="title" class="w-full p-2 border rounded">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea wire:model="description" class="w-full p-2 border rounded"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Category</label>
            <select wire:model="category" class="w-full p-2 border rounded">
                <option value="">Select Category</option>
                <option value="counting">Counting</option>
                <option value="addition">Addition</option>
                <option value="subtraction">Subtraction</option>
<option value="multiplication">Multiplication</option>
<option value="division">Division</option>
                <option value="pattern">Pattern</option>
            </select>
            @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Difficulty</label>
            <select wire:model="difficulty" class="w-full p-2 border rounded">
                <option value="">Select Difficulty</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>

            </select>
            @error('difficulty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
            Add Game
        </button>
    </form>
</div>
