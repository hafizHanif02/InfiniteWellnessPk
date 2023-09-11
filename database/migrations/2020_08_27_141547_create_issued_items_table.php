<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issued_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->string('issued_by');
            $table->date('issued_date');
            $table->date('return_date')->nullable();
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('issued_items');
    }
};
