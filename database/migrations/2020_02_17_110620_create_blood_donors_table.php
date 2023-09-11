<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blood_donors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->integer('gender');
            $table->string('blood_group');
            $table->dateTime('last_donate_date')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blood_donors');
    }
};
