<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipd_diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ipd_patient_department_id')->constrained()->cascadeOnDelete();
            $table->string('report_type');
            $table->datetime('report_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('ipd_diagnoses');
    }
};
