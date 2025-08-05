<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabEnvironmentsTable extends Migration
{
    public function up(): void
    {
        Schema::create('lab_environments', function (Blueprint $table) {
            $table->id();
            $table->string('schema_name')->unique();
            $table->text('setup_script');
            $table->text('teardown_script');
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_environments');
    }
}
