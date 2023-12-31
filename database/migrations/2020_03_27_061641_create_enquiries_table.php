<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            // $table->foreignId('viewed_by_id')->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->string('contact_no')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->text('message');
            $table->unsignedBigInteger('viewed_by')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
