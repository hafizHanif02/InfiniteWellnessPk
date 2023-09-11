<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('front_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('short_description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('front_services');
    }
};
