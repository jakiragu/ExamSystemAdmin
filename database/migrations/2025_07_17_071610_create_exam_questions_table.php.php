<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exam_objective_id'); // FK
            $table->text('question_text');
            $table->string('difficulty_level')->nullable(); // Beginner, Intermediate, Advanced
            $table->text('expected_action')->nullable(); // Instruction or command expected from student
            $table->text('sample_input')->nullable();
            $table->text('expected_output')->nullable();
            $table->foreignId('lab_env_id')->nullable()->constrained('lab_environments')->onDelete('set null');
            $table->enum('evaluation_type', ['Auto', 'Manual', 'Mixed'])->default('Manual');
            $table->string('question_type')->default('MCQ'); // e.g., MCQ, Written
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('exam_objective_id')
                  ->references('id')
                  ->on('exam_objectives')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};
