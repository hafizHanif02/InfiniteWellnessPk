<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->integer('income_head');
            $table->string('name');
            $table->string('invoice_number')->nullable();
            $table->dateTime('date')->index();
            $table->double('amount');
            $table->text('description')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
