<?php

use App\Livewire\GameList;
use App\Livewire\StudentList;
use App\Livewire\CountingGame;
use App\Livewire\GameSessionPage;
use App\Livewire\ShapePuzzleGame;
use App\Livewire\StudentGameList;
use App\Livewire\StudentProgress;
use Illuminate\Support\Facades\Route;
use App\Livewire\CompletingPatternsGame;
use App\Livewire\Dashboard\ParentDashboard;
use App\Livewire\Dashboard\StudentDashboard;
use App\Livewire\Dashboard\TeacherDashboard;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'teacher' => redirect()->route('teacher.dashboard'),
            'parent' => redirect()->route('parent.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    })->name('dashboard');

    Route::get('/teacher/dashboard', TeacherDashboard::class)
        ->middleware('role:teacher')
        ->name('teacher.dashboard');

    Route::get('/parent/dashboard', ParentDashboard::class)
        ->middleware('role:parent')
        ->name('parent.dashboard');

    Route::get('/student/dashboard', StudentDashboard::class)
        ->middleware('role:student')
        ->name('student.dashboard');

    Route::prefix('/teacher')->name('teacher.')->group(function () {
        Route::get('/game-list', GameList::class)->name('game.list');
        Route::get('/student-list', StudentList::class)->name('student.list');
        Route::get('/student/{studentId}/progress', StudentProgress::class)->name('student.progress');
    });

    Route::middleware(['role:student'])->prefix('/student')->name('student.')->group(function () {
        Route::get('/games', StudentGameList::class)->name('games');
        Route::get('/game-session/arithmetic/{game}', GameSessionPage::class)->name('game.play');
        Route::get('/game-session/counting/{game}', CountingGame::class)->name('game.play.count');
        Route::get('/game-session/completing-patterns/{game}', CompletingPatternsGame::class)->name('game.play.pattern');
    });

});