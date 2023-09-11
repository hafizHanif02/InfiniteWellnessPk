<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_number')->index();
            $table->string('vehicle_model');
            $table->string('year_made');
            $table->string('driver_name');
            $table->string('driver_license');
            $table->string('driver_contact');
            $table->text('note')->nullable();
            $table->boolean('is_available')->default(1);
            $table->integer('vehicle_type')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('ambulances');
    }
};
