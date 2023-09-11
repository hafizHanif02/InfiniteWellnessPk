<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('consultation_title');
            $table->dateTime('consultation_date');
            $table->string('consultation_duration_minutes');
            $table->boolean('host_video');
            $table->boolean('participant_video');
            $table->text('description')->nullable();
            $table->string('created_by');
            $table->text('meta')->nullable();
            $table->string('time_zone')->default(null);
            $table->string('password');
            $table->integer('status');
            $table->string('meeting_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_meetings');
    }
};
