<div class="p-4 bg-white shadow-md rounded-lg">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Game List</h2>
        <!-- The button to open modal -->
        <button onclick="addGameModal.showModal()" class="btn btn-primary">Add Game</label>
    </div>

    @if (session()->has('success') OR session()->has('message'))
        <div class="p-2 mb-2 text-green-700 bg-green-100 border border-green-300 rounded">
            {{ session('success') }} {{ session('message') }}
        </div>
    @endif


    <input type="text" wire:model="search" placeholder="Search games..." class="w-full p-2 mb-2 border rounded">

    <table class="w-full text-left border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Title</th>
                <th class="p-2 border">Category</th>
                <th class="p-2 border">Difficulty</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($games as $game)
                <tr>
                    <td class="p-2 border">{{ $game->title }}</td>
                    <td class="p-2 border">{{ ucfirst($game->category) }}</td>
                    <td class="p-2 border">{{ ucfirst($game->difficulty) }}</td>
                    <td class="p-2 border">
                        <button wire:click="editGame({{ $game->id }})" class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</button>
                        <button wire:click="deleteGame({{ $game->id }})" class="px-2 py-1 text-white bg-red-500 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-2">
        {{ $games->links() }}
    </div>

    @if ($editing)
        <div class="mt-4 p-4 bg-gray-100 rounded">
            <h3 class="text-lg font-semibold">Edit Game</h3>

            <form wire:submit.prevent="updateGame">
                <div class="mb-2">
                    <label class="block">Title</label>
                    <input type="text" wire:model="title" class="w-full p-2 border rounded">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-2">
                    <label class="block">Description</label>
                    <textarea wire:model="description" class="w-full p-2 border rounded"></textarea>
                </div>

                <div class="mb-2">
                    <label class="block">Category</label>
                    <select wire:model="category" class="w-full p-2 border rounded">
                        <option value="counting">Counting</option>
                        <option value="addition">Addition</option>
                        <option value="subtraction">Subtraction</option>
                        <option value="multiplication">Multiplication</option>
                        <option value="division">Division</option>
                        <option value="pattern">Pattern</option>


            </select>
                </div>

                <div class="mb-2">
                    <label class="block">Difficulty</label>
                    <select wire:model="difficulty" class="w-full p-2 border rounded">
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>

            </select>
                </div>

                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">Update Game</button>
                <button type="button" wire:click="$set('editing', false)" class="px-4 py-2 text-white bg-gray-500 rounded">Cancel</button>
            </form>
        </div>
    @endif


    <dialog id="addGameModal" class="modal" wire:ignore.self>
        <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <div class="py-4">
            @livewire('add-game')
        </div>
        </div>
    </dialog>
</div>
