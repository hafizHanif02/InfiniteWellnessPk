<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipd_prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ipd_patient_department_id')->constrained()->cascadeOnDelete();
            $table->text('header_note')->nullable();
            $table->text('footer_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ipd_prescriptions');
    }
};
