<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_return_notes', function (Blueprint $table) {
            $table->id()->startingValue(3001);
            $table->foreignId('good_receive_note_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->integer('price');
            $table->tinyInteger('status')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_return_notes');
    }
};
