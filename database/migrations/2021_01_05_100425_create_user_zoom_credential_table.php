<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_zoom_credential', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('zoom_api_key');
            $table->string('zoom_api_secret');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_zoom_credential');
    }
};
