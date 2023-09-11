<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency_name');
            $table->string('currency_icon');
            $table->string('currency_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::drop('currency_settings');
    }
};
