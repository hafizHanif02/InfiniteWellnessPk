<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('collection_name', 160);
            $table->string('name', 160);
            $table->string('file_name', 160);
            $table->string('mime_type', 160)->nullable();
            $table->string('disk', 160);
            $table->unsignedBigInteger('size');
            $table->text('manipulations');
            $table->text('custom_properties');
            $table->text('responsive_images');
            $table->unsignedInteger('order_column')->nullable();
            $table->string('conversions_disk')->nullable();
            $table->uuid('uuid')->nullable()->unique();
            $table->text('generated_conversions');
            $table->nullableTimestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
