<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_admissions', function (Blueprint $table) {
            $table->id();
            $table->string('patient_admission_id', 160)->unique();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('insurance_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bed_id')->constrained()->cascadeOnDelete();
            $table->datetime('admission_date')->index();
            $table->datetime('discharge_date')->nullable();
            $table->string('policy_no')->nullable();
            $table->string('agent_name')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->string('guardian_address')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('patient_admissions');
    }
};
