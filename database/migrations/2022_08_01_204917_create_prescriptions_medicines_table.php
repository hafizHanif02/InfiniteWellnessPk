<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions_medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('prescription_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('medicine_id');
            $table->string('dosage')->nullable();
            $table->string('day')->nullable();
            $table->string('time')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('prescriptions_medicines');
    }
};
