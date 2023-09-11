<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opd_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_patient_department_id')->constrained()->cascadeOnDelete();
            $table->string('report_type');
            $table->datetime('report_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opd_diagnoses');
    }
};
