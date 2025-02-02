<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->integer('total_games');
            $table->decimal('average_score', 5, 2);
            $table->integer('highest_score');
            $table->timestamp('last_played')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('progress');
    }
};