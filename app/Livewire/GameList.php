<?php
namespace App\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Game;
use Livewire\WithPagination;

class GameList extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search = '';
    public $gameId, $title, $description, $category, $difficulty;
    public $editing = false;


    #[On("gameAdded")]
    public function refreshList()
    {
        $this->resetPage();
    }

    public function editGame($id)
    {
        $game = Game::findOrFail($id);
        $this->gameId = $game->id;
        $this->title = $game->title;
        $this->description = $game->description;
        $this->category = $game->category;
        $this->difficulty = $game->difficulty;
        $this->editing = true;
    }

    public function updateGame()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:counting,addition,subtraction,multiplication,division,pattern,shapes',
            'difficulty' => 'required|in:easy,medium,hard',
        ]);

        Game::where('id', $this->gameId)->update([
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'difficulty' => $this->difficulty,
        ]);

        $this->alert('success', 'Game updated successfully!');
        $this->reset(['gameId', 'title', 'description', 'category', 'difficulty', 'editing']);
        $this->refreshList();
    }

    public function deleteGame($id)
    {
        Game::findOrFail($id)->delete();
        $this->alert('success', 'Game deleted successfully!');
        $this->refreshList();
    }

    public function render()
    {
        return view('livewire.game-list', [
            'games' => Game::where('title', 'like', "%{$this->search}%")->paginate(5),
        ]);
    }
}
