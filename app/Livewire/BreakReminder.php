<?php
namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class BreakReminder extends Component
{
    public $showReminder = false;

    #[On('startBreakTimer')]
    public function startBreakTimer()
    {
        $this->dispatch('start-break-timer');
    }

    public function dismissReminder()
    {
        $this->showReminder = false;
        session(['lastInteraction' => now()]);
        $this->startBreakTimer();
    }

    public function mount()
    {
        $this->dispatch('start-break-timer');
    }

    public function render()
    {
        return view('livewire.break-reminder');
    }
}