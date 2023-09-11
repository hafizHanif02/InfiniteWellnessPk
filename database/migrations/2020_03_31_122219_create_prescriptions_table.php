<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->string('food_allergies')->nullable();
            $table->string('tendency_bleed')->nullable();
            $table->string('heart_disease')->nullable();
            $table->string('high_blood_pressure')->nullable();
            $table->string('diabetic')->nullable();
            $table->string('surgery')->nullable();
            $table->string('accident')->nullable();
            $table->string('others')->nullable();
            $table->string('medical_history')->nullable();
            $table->string('current_medication')->nullable();
            $table->string('female_pregnancy')->nullable();
            $table->string('breast_feeding')->nullable();
            $table->string('health_insurance')->nullable();
            $table->string('low_income')->nullable();
            $table->string('reference')->nullable();
            $table->boolean('status')->nullable();
            $table->string('plus_rate')->nullable();
            $table->string('temperature')->nullable();
            $table->string('problem_description')->nullable();
            $table->string('test')->nullable();
            $table->string('advice')->nullable();
            $table->string('next_visit_qty')->nullable();
            $table->string('next_visit_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('prescriptions');
    }
};
