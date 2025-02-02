<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Game;
use App\Models\Student;
use Livewire\Component;
use App\Models\GameSession;
use App\Services\ProgressService;
use Livewire\Attributes\Computed;

class GameSessionPage extends Component
{

    protected $progressService;
    public $game, $student, $score = 0, $questions = [], $currentQuestion = 0,
           $mistakes = 0, $completedLevel = 1, $startTime, $gameOver = false;


    public function boot(ProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function mount(Game $game)
    {
        $studentId = auth()->user()->student->id;
        $this->game = $game;
        $this->student = Student::findOrFail($studentId);
        $this->questions = $this->generateQuestions($game->category, $game->difficulty);
        $this->startTime = Carbon::now();
    }

    public function generateQuestions($category, $difficulty)
    {
        $operator = '+'; // Default operator
        switch($category){
            case 'addition':
                $operator = '+';
                break;
            case 'subtraction':
                $operator = '-';
                break;
            case 'multiplication':
                $operator = '*';
                break;
            case 'division':
                $operator = '/';
                break;
        }
        $questions = [];
        for ($i = 0; $i < 10; $i++) {
            $a = rand(1, 10);
            $b = rand(1, 10);

            if ($operator == '-' && $a < $b) {
                list($a, $b) = [$b, $a]; // Swap to ensure $a is larger
            }

            $answer = eval("return $a $operator $b;");

            $questions[] = [
                'question' => "$a $operator $b = ?",
                'correct_answer' => $answer,
                'operator' => $operator,
                'user_answer' => null,
            ];
        }
        return $questions;
    }

    public function submitAnswer($answer)
    {
        if ($answer == $this->questions[$this->currentQuestion]['correct_answer']) {
            $this->score += 1;
        } else {
            $this->mistakes++;
        }

        $this->questions[$this->currentQuestion]['user_answer'] = $answer;

        if ($this->currentQuestion < count($this->questions) - 1) {
            $this->currentQuestion++;
        } else {
            $this->completedLevel++;
            $this->gameOver = true;
            $this->endGame();
        }
    }

    public function endGame()
    {
        $duration = Carbon::now()->diffInSeconds($this->startTime);
        $correctAnswers = collect($this->questions)->where('user_answer', '!==', null)
                                                   ->filter(fn($q) => $q['user_answer'] == $q['correct_answer'])
                                                   ->count();
        $accuracy = ($correctAnswers / count($this->questions)) * 100;

        $session = GameSession::create([
            'student_id' => $this->student->id,
            'game_id' => $this->game->id,
            'score' => $this->score,
            'mistakes_count' => $this->mistakes,
            'completed_level' => $this->completedLevel,
            'accuracy' => $accuracy,
            'duration' => $duration,
            'difficulty' => $this->game->difficulty,
        ]);

        $this->progressService->updateProgress($session->student);

        session()->flash('message', 'Game Session Completed!');
    }

    #[Computed()]
    private function calculateAccuracy()
    {
        $total = $this->score + $this->mistakes;
        return $total ? round(($this->score / $total) * 100, 2) : 0;
    }



    public function render()
    {
        return view('livewire.game-session-page');
    }
}