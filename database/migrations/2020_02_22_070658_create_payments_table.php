<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();
            $table->date('payment_date')->index();
            $table->string('pay_to');
            $table->double('amount');
            $table->text('description')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('payments');
    }
};
