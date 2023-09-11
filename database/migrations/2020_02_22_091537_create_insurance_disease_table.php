<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insurance_diseases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insurance_id')->constrained()->cascadeOnDelete();
            $table->string('disease_name');
            $table->double('disease_charge');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_diseases');
    }
};
