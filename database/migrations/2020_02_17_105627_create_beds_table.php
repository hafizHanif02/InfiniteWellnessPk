<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bed_type_id')->constrained()->cascadeOnDelete();
            $table->string('bed_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('charge');
            $table->boolean('is_available')->index()->default(1);
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('beds');
    }
};
