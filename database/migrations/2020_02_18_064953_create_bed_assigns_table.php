<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bed_assigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bed_id')->constrained()->cascadeOnDelete();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ipd_patient_department_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('case_id');
            $table->dateTime('assign_date')->index();
            $table->dateTime('discharge_date')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('bed_assigns');
    }
};
