<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vaccinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('manufactured_by');
            $table->string('brand');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
