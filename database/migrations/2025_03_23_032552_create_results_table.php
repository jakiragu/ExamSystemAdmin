<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('results', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('CertificationID');
        $table->integer('score');
        $table->float('percentage');
        $table->timestamps();
        
        $table->foreign('CertificationID')->references('id')->on('candidates')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
