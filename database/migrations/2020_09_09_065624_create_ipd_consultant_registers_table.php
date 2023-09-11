<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipd_consultant_registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ipd_patient_department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->dateTime('applied_date');
            $table->text('instruction');
            $table->date('instruction_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('ipd_consultant_registers');
    }
};
