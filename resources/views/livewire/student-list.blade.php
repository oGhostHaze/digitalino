<div class="p-4 bg-white shadow-md rounded-lg">
    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Student List</h2>
        <!-- The button to open modal -->
        <button onclick="addStudentModal.showModal()" class="btn btn-primary">Add Student</label>
    </div>

    @if (session()->has('success'))
        <div class="p-2 mb-2 text-green-700 bg-green-100 border border-green-300 rounded">
            {{ session('success') }}
        </div>
    @endif


    <input type="text" wire:model.lazy="search" placeholder="Search students..." class="w-full p-2 mb-2 border rounded">

    <table class="w-full text-left border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Name</th>
                <th class="p-2 border">Age</th>
                <th class="p-2 border">Parent</th>
                <th class="p-2 border">Teacher</th>
                <th class="p-2 border">Username</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td class="p-2 border">{{ $student->name }}</td>
                    <td class="p-2 border">{{ ucfirst($student->age) }}</td>
                    <td class="p-2 border">{{ ucfirst($student->parent->name) }}</td>
                    <td class="p-2 border">{{ ucfirst($student->teacher->name) }}</td>
                    <td class="p-2 border">{{ $student->account->username }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('teacher.student.progress', [$student->id]) }}" class="px-2 py-1 text-white bg-green-500 rounded">Progress</a>
                        <button wire:click="editStudent({{ $student->id }})" class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</button>
                        <button wire:click="deleteStudent({{ $student->id }})" class="px-2 py-1 text-white bg-red-500 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-2">
        {{ $students->links() }}
    </div>

    @if ($editing)
        <div class="mt-4 p-4 bg-gray-100 rounded">
            <h3 class="text-lg font-semibold">Edit Student</h3>

            <form wire:submit.prevent="updateStudent">
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
                        @foreach ($parents as $parent)
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
    @endif


    <dialog id="addStudentModal" class="modal" wire:ignore.self>
        <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <div class="py-4">
            @livewire('add-student')
        </div>
        </div>
    </dialog>
</div>
