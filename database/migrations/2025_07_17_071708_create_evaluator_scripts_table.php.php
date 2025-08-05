<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluatorScriptsTable extends Migration
{
    public function up(): void
    {
        Schema::create('evaluator_scripts', function (Blueprint $table) {
            $table->id('script_id');
            $table->unsignedBigInteger('question_id');
            $table->text('script_body'); // actual script or command block
            $table->string('script_language')->default('bash'); // or SQL, Python, etc.
            $table->text('expected_output')->nullable();
            $table->timestamps();

            $table->foreign('question_id')
                ->references('id')->on('exam_questions')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluator_scripts');
    }
}
