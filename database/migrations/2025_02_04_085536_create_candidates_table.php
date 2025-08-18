<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id(); // auto-increment primary key
            $table->string('CertificationID')->nullable()->unique(); // optional for now
            $table->string('FullName');
            $table->string('Email')->unique;
            $table->string('Organization');
            $table->string('Occupation');
            $table->string('MobileNo');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
