<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vaccinated_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vaccination_id')->constrained()->cascadeOnDelete();
            $table->string('vaccination_serial_number')->nullable();
            $table->bigInteger('dose_number');
            $table->dateTime('dose_given_date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
