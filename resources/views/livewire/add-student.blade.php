<div class="p-4 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-semibold text-gray-700">Add New Student</h2>

    <form wire:submit.prevent="saveStudent">
        <div class="mb-4">
            <label class="block text-gray-700">Name</label>
            <input type="text" wire:model="name" class="w-full p-2 border rounded">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Age</label>
            <input type="number" wire:model="age" class="w-full p-2 border rounded">
            @error('age') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Parent</label>
            <select wire:model="parent_id" class="w-full p-2 border rounded">
                <option value="">Select Parent</option>
                @foreach ($this->parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach

            </select>
            @error('parent_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
            Add Student
        </button>
    </form>
</div>
