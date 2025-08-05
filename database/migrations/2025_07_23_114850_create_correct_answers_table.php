<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('correct_answers', function (Blueprint $table) {
            $table->id();
            $table->text('answer_text');
            $table->unsignedBigInteger('question_id');
            $table->timestamps();

            $table->foreign('question_id')
                  ->references('id')
                  ->on('exam_questions')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('correct_answers');
    }
};
