<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;
use App\Models\GameSession;
use Livewire\Attributes\On;
use App\Services\ProgressService;

class CompletingPatternsGame extends Component
{
    public $patterns = [];
    protected $progressService;
    public $currentPattern = 0;
    public $score = 0;
    public $game;
    public $mistakesCount = 0;
    public $startTime;
    public $completedLevel = 1; // Assuming level-based progression
    public $studentId; // Authenticated student ID
    public $gameId;    // ID of the Pattern Game
    public $gameOver = false;


    public function boot(ProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function mount(Game $game)
    {

        $this->patterns = [
            // Repeating Pattern
            [
                'sequence' => ['🐱', '🐶', '🐱', '🐶', '❓'],
                'correct_answer' => '🐱',
                'options' => ['🐱', '🐶', '🐰'],
            ],
            // Alternating Colors
            [
                'sequence' => ['🔴', '🟢', '🔴', '🟢', '❓'],
                'correct_answer' => '🔴',
                'options' => ['🔴', '🔵', '🟡'],
            ],
            // Shape Pattern
            [
                'sequence' => ['⭐', '⚫', '⭐', '⚫', '❓'],
                'correct_answer' => '⭐',
                'options' => ['⭐', '🔺', '⬛'],
            ],
            // Increasing Pattern
            [
                'sequence' => ['1️⃣', '2️⃣', '3️⃣', '4️⃣', '❓'],
                'correct_answer' => '5️⃣',
                'options' => ['4️⃣', '5️⃣', '6️⃣'],
            ],
            // Complex Pattern
            [
                'sequence' => ['🚗', '✈️', '🚗', '🚀', '🚗', '✈️', '🚗', '❓'],
                'correct_answer' => '🚀',
                'options' => ['🚗', '✈️', '🚀'],
            ],
        ];

        $this->startTime = now();
        $this->studentId = auth()->user()->student->id;  // Ensure the student is authenticated
        $this->gameId = $game->id; // Example: Game ID for Pattern Game
    }

    #[On('checkAnswer')]
    public function checkAnswer($data)
    {
        $selected = $data;
        $currentPattern = $this->patterns[$this->currentPattern];

        // Check if the answer is correct
        if ($selected === $currentPattern['correct_answer']) {
            $this->score++;
            session()->flash('success', 'Correct! 🎉');
        } else {
            $this->mistakesCount++;
            session()->flash('error', 'Oops! Try again. ❌');
        }

        // Move to the next pattern or end the game
        if ($this->currentPattern < count($this->patterns) - 1) {
            $this->currentPattern++;  // Go to the next pattern
        } else {
            $this->gameOver();        // End the game
        }
    }

    public function gameOver()
    {
        $this->gameOver = true;
        $duration = now()->diffInSeconds($this->startTime);
        $accuracy = $this->calculateAccuracy();

        // Save the game session
        $session = GameSession::create([
            'student_id'      => $this->studentId,
            'game_id'         => $this->gameId,
            'score'           => $this->score,
            'mistakes_count'  => $this->mistakesCount,
            'completed_level' => $this->completedLevel,
            'accuracy'        => $accuracy,
            'duration'        => $duration,
            'difficulty'      => 'medium', // Or dynamic based on the game
        ]);

        $this->progressService->updateProgress($session->student);

        session()->flash('game_over', '🎯 Game Over! Your Score: ' . $this->score);
        $this->resetGame();
    }
    public function resetGame()
    {
        $this->currentPattern = 0;
        $this->score = 0;
        shuffle($this->patterns); // Optional: Shuffle for a fresh start
    }

    private function calculateAccuracy()
{
    $totalAttempts = $this->score + $this->mistakesCount;
    return $totalAttempts > 0 ? round(($this->score / $totalAttempts) * 100, 2) : 0;
}



    public function render()
    {
        return view('livewire.completing-patterns-game');
    }
}