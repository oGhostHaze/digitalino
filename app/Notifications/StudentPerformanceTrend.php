<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StudentPerformanceTrend extends Notification implements ShouldQueue
{
    use Queueable;

    protected $student;
    protected $trend;

    public function __construct($student, $trend)
    {
        $this->student = $student;
        $this->trend = $trend;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Student {$this->student->name} is showing a {$this->trend} trend in performance.",
            'student_id' => $this->student->id,
        ];
    }
}