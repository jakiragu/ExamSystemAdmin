<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('correct_answers', function (Blueprint $table) {
            $table->id('AnswerID');
            $table->string('AnswerText');
            $table->unsignedBigInteger('QuestionID');
            $table->timestamps();
            $table->foreign('QuestionID')->references('QuestionID')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correct_answers');
    }
};
