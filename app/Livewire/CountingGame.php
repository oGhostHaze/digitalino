<?php

namespace App\Livewire;

use App\Models\Game;
use Livewire\Component;
use App\Models\GameSession;
use App\Services\ProgressService;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class CountingGame extends Component
{
    protected $progressService;
    public $objectsToCount = [];
    public $correctAnswer;
    public $options = [];
    public $score = 0;
    public $mistakes = 0;
    public $level = 1;
    public $difficulty = 'easy';
    public $questionCount = 0;
    public $maxQuestions = 10; // Stop after 10 questions
    public $gameOver = false;
    public $game;


    public function boot(ProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function mount(Game $game)
    {
        $this->game = $game;
        $this->generateQuestion();
    }

    public function generateQuestion()
    {
        if ($this->questionCount >= $this->maxQuestions) {
            $this->endGame();
            return;
        }

        $range = match ($this->difficulty) {
            'easy' => [1, 5],
            'medium' => [5, 10],
            'hard' => [10, 20],
        };

        $this->correctAnswer = rand($range[0], $range[1]);
        $this->objectsToCount = array_fill(0, $this->correctAnswer, '🐼');

        // Ensure the correct answer is always present
        $this->options = [$this->correctAnswer];

        while (count($this->options) < 4) {
            $option = max(1, $this->correctAnswer + rand(-3, 3));
            if (!in_array($option, $this->options)) {
                $this->options[] = $option;
            }
        }

        shuffle($this->options);
        $this->questionCount++;
    }

    public function submitAnswer($answer)
    {
        if ($this->gameOver) return;

        if ($answer == $this->correctAnswer) {
            $this->score++;
            $this->level++;

            if ($this->score % 5 == 0) {
                $this->difficulty = $this->difficulty === 'easy' ? 'medium' : 'hard';
            }
        } else {
            $this->mistakes++;
        }

        if ($this->questionCount >= $this->maxQuestions) {
            $this->endGame();
        } else {
            $this->generateQuestion();
        }
    }

    public function endGame()
    {
        $this->gameOver = true;
        $this->saveGameSession();
    }

    public function saveGameSession()
    {
        $session = GameSession::create([
            'student_id' => Auth::user()->student->id,
            'game_id' => $this->game->id,
            'score' => $this->score,
            'mistakes_count' => $this->mistakes,
            'completed_level' => $this->level,
            'accuracy' => $this->calculateAccuracy(),
            'duration' => 300,
            'difficulty' => $this->difficulty,
        ]);

        $this->progressService->updateProgress($session->student);
    }

    #[Computed()]
    private function calculateAccuracy()
    {
        $total = $this->score + $this->mistakes;
        return $total ? round(($this->score / $total) * 100, 2) : 0;
    }

    public function render()
    {
        return view('livewire.counting-game');
    }
}