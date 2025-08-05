<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectAreasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subject_areas', function (Blueprint $table) {
            $table->id(); // This will be used as the referenced key in exam_objectives
            $table->unsignedBigInteger('exam_catalog_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('subject_areas');
    }
}
