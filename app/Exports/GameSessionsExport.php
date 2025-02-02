<?php
namespace App\Exports;

use App\Models\GameSession;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GameSessionsExport implements FromCollection, WithHeadings
{
    protected $studentId;

    public function __construct($studentId)
    {
        $this->studentId = $studentId;
    }

    public function collection()
    {
        return GameSession::with('game')
            ->where('student_id', $this->studentId)
            ->get()
            ->map(function ($session) {
                return [
                    'Game Title'       => $session->game->title,
                    'Score'            => $session->score,
                    'Mistakes Count'   => $session->mistakes_count,
                    'Completed Level'  => $session->completed_level,
                    'Accuracy (%)'     => $session->accuracy,
                    'Duration (secs)'  => $session->duration,
                    'Difficulty'       => ucfirst($session->difficulty),
                    'Date Played'      => $session->created_at->format('Y-m-d H:i:s'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Game Title',
            'Score',
            'Mistakes Count',
            'Completed Level',
            'Accuracy (%)',
            'Duration (secs)',
            'Difficulty',
            'Date Played',
        ];
    }
}