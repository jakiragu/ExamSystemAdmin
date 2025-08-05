<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_objectives', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_area_id');
            $table->unsignedBigInteger('exam_catalog_id');
            $table->text('description')->nullable();
            $table->string('objective_title');
            $table->timestamps();

            // Foreign key to subject_areas.id
            $table->foreign('subject_area_id')
                ->references('id')
                ->on('subject_areas')
                ->onDelete('cascade');

            // Foreign key to exam_catalogs.id
            $table->foreign('exam_catalog_id')
                ->references('id')
                ->on('exam_catalogs')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_objectives');
    }
}
