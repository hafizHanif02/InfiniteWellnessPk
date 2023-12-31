<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postals', function (Blueprint $table) {
            $table->id();
            $table->string('from_title')->nullable();
            $table->string('to_title')->nullable();
            $table->string('reference_no')->nullable();
            $table->date('date')->nullable();
            $table->text('address')->nullable();
            $table->integer('type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postals');
    }
};
