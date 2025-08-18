<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('candidate_exam_bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->foreignId('exam_catalog_id')->constrained('exam_catalogs')->cascadeOnDelete();

            $table->dateTime('scheduled_at');

            $table->enum('status', ['booked', 'paid', 'cancelled', 'missed', 'completed'])->default('booked');
            $table->enum('payment_status', ['pending', 'confirmed', 'waived'])->default('pending');
            $table->unsignedInteger('reschedule_count')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('candidate_exam_bookings');
    }
};


