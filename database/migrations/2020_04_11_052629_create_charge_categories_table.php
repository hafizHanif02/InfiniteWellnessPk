<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charge_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->integer('charge_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('charge_categories');
    }
};
