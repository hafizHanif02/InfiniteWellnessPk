<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160)->index();
            $table->tinyInteger('type');
            $table->text('description')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('accounts');
    }
};
