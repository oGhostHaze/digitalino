<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentProgressExport implements FromCollection, WithHeadings
{
    protected $studentId;

    public function __construct($studentId)
    {
        $this->studentId = $studentId;
    }

    public function collection()
    {
        return Student::with('progress', 'gameSessions')
            ->where('id', $this->studentId)
            ->get()
            ->map(function ($student) {
                return [
                    'Name' => $student->name,
                    'Total Games' => $student->progress->total_games,
                    'Average Score' => $student->progress->average_score,
                    'Highest Score' => $student->progress->highest_score,
                    'Last Played' => $student->progress->last_played,
                ];
            });
    }

    public function headings(): array
    {
        return ['Name', 'Total Games', 'Average Score', 'Highest Score', 'Last Played'];
    }
}