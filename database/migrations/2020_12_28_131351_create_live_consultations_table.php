<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('consultation_title');
            $table->dateTime('consultation_date');
            $table->boolean('host_video');
            $table->boolean('participant_video');
            $table->string('consultation_duration_minutes');
            $table->string('type');
            $table->string('type_number');
            $table->string('created_by');
            $table->integer('status');
            $table->text('description')->nullable();
            $table->string('meeting_id');
            $table->text('meta')->nullable();
            $table->string('time_zone')->default(null);
            $table->string('password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_consultations');
    }
};
