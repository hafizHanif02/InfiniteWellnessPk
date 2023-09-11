<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bill_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->foreignId('bill_id')->constrained()->cascadeOnDelete();
            $table->integer('qty')->unsigned();
            $table->double('price', 8, 2);
            $table->double('amount', 16, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_items');
    }
};
