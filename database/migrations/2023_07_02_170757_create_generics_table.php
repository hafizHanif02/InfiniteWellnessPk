<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generics', function (Blueprint $table) {
            $table->id()->startingValue(18880);
            $table->string('formula')->unique();
            $table->text('generic_detail')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('generics');
    }
};
