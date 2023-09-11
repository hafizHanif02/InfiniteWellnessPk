<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->double('quantity');
            $table->double('rate');
            $table->double('amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_services');
    }
};
