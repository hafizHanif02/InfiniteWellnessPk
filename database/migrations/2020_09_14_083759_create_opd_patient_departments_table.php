<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opd_patient_departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->bigInteger('case_id');
            $table->string('opd_number', 160)->unique();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('bp')->nullable();
            $table->text('symptoms')->nullable();
            $table->text('notes')->nullable();
            $table->datetime('appointment_date');
            $table->boolean('is_old_patient')->nullable()->default(false);
            $table->double('standard_charge');
            $table->tinyInteger('payment_mode');
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opd_patient_departments');
    }
};
