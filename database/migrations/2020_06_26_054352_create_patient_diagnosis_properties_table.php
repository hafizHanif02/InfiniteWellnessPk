<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_diagnosis_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_diagnosis_test_id')->constrained()->cascadeOnDelete();
            $table->string('property_name')->nullable();
            $table->string('property_value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_diagnosis_properties');
    }
};
