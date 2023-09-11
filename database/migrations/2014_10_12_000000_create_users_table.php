<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('first_name')->index();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('designation')->nullable();
            $table->string('phone')->nullable();
            $table->integer('gender');
            $table->string('qualification')->nullable();
            $table->string('blood_group')->nullable();
            $table->date('dob')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('owner_id')->nullable();
            $table->string('owner_type')->nullable();
            $table->boolean('status');
            $table->string('language')->default('en');
            $table->string('thememode')->default(0);
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedIn_url')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
