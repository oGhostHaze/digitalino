<?php

namespace App\Livewire;

use App\Models\Game;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddGame extends Component
{
    use LivewireAlert;

    public $title, $description, $category, $difficulty;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category' => 'required|in:counting,addition,subtraction,multiplication,division,pattern,shapes',
        'difficulty' => 'required|in:easy,medium,hard',
    ];

    public function saveGame()
    {
        $this->validate();

        Game::create([
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'difficulty' => $this->difficulty,
        ]);

        $this->alert('success', 'Game added successfully!');
        $this->reset(); // Clear input fields after saving
        $this->dispatch('gameAdded'); // Notify other components
    }

    public function render()
    {
        return view('livewire.add-game');
    }
}