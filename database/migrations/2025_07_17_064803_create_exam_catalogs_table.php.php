<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exam_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('exam_code')->unique();
            $table->string('exam_title');
            $table->integer('duration_minutes');
            $table->enum('status', ['draft', 'scheduled', 'active', 'paused', 'stopped'])->default('draft');
            $table->timestamp('start_time')->nullable();   // When exam goes live
            $table->timestamp('end_time')->nullable();     // When exam expires or is ended
            $table->unsignedBigInteger('lab_env_id')->nullable(); // Allow null for flexibility
            $table->boolean('is_visible_to_students')->default(false); // UI visibility toggle
            $table->timestamps();


            $table->foreign('lab_env_id')->references('id')->on('lab_environments')->nullOnDelete();



        });
    }

    public function down(): void {
        Schema::dropIfExists('exam_catalogs');
    }
};
