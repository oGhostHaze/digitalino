<?php

namespace Database\Seeders;

use App\Models\Game;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

     public function run(): void {
        // Create a teacher
        $teacher = User::create([
            'name' => 'Teacher John',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher'
        ]);

        // Create a student
        $student = Student::create([
            'parent_id' => null,
            'teacher_id' => $teacher->id,
            'name' => 'Student Alice',
            'age' => 5
        ]);

        // Create a game
        Game::create([
            'title' => 'Counting Fun',
            'description' => 'A game to learn counting numbers',
            'category' => 'counting',
            'difficulty' => 'easy'
        ]);
    }
}