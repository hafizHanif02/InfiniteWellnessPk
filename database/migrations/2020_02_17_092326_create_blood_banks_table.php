<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_banks', function (Blueprint $table) {
            $table->id();
            $table->string('blood_group');
            $table->bigInteger('remained_bags')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('blood_banks');
    }
};
