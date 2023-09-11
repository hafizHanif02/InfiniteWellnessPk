<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('send_by');
            $table->bigInteger('send_to')->nullable();
            $table->string('phone_number');
            $table->text('message');
            $table->string('region_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms');
    }
};
