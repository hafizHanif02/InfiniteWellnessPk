<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('radiology_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radiology_categories');
    }
};
