<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ambulance_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ambulance_id')->constrained()->cascadeOnDelete();
            $table->string('driver_name');
            $table->date('date')->index();
            $table->double('amount', 8, 2);
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('ambulance_calls');
    }
};
