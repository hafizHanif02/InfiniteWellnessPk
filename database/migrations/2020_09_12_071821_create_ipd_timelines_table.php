<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipd_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ipd_patient_department_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->date('date');
            $table->text('description')->nullable();
            $table->boolean('visible_to_person')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('ipd_timelines');
    }
};
