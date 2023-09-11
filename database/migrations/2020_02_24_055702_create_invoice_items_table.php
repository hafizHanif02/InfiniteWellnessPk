<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->double('price', 8, 2);
            $table->double('total', 8, 2);
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('invoice_items');
    }
};
