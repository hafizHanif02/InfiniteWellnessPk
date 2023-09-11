<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->string('available_on');
            $table->time('available_from');
            $table->time('available_to');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_day');
    }
};
