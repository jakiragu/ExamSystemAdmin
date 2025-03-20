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
        Schema::create('answers', function (Blueprint $table) {
            $table->id('AnswerID');
            $table->text('text');
            $table->unsignedBigInteger('QuestionID'); 
            $table->string('CertificationID');
            $table->string('Status')->default('ungraded');
            $table->timestamps();
            $table->foreign('QuestionID')->references('QuestionID')->on('questions')->onDelete('cascade');
            $table->foreign('CertificationID')->references('CertificationID')->on('candidates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
