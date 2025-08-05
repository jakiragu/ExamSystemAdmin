<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('candidate_id'); // FK to candidates.id
            $table->unsignedBigInteger('question_id');  // FK to exam_questions.id
            $table->text('answer_text')->nullable();    // Actual student answer
            $table->boolean('is_correct')->nullable();  // Auto-grading result
            $table->timestamps();

            // Foreign keys
            $table->foreign('candidate_id')
                ->references('id')->on('candidates')
                ->onDelete('cascade');

            $table->foreign('question_id')
                ->references('id')->on('exam_questions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
