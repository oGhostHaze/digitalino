<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Game;

class StudentGameList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $difficulty = '';

    public function render()
    {
        $games = Game::query()
            ->when($this->search, fn ($query) => $query->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->category, fn ($query) => $query->where('category', $this->category))
            ->when($this->difficulty, fn ($query) => $query->where('difficulty', $this->difficulty))
            ->paginate(6);

        return view('livewire.student-game-list', compact('games'));
    }
}