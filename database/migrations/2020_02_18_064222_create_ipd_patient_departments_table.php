<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipd_patient_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bed_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bed_id')->constrained()->cascadeOnDelete();
            $table->bigInteger('case_id');
            $table->string('ipd_number', 160)->unique();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('bp')->nullable();
            $table->text('symptoms')->nullable();
            $table->text('notes')->nullable();
            $table->datetime('admission_date');
            $table->boolean('is_old_patient')->nullable()->default(false);
            $table->boolean('bill_status')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('ipd_patient_departments');
    }
};
