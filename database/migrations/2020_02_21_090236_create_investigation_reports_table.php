<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigation_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->dateTime('date')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigation_reports');
    }
};
