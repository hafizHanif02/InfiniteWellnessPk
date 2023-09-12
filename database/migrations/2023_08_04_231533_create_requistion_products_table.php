<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requistion_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requistion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('limit');
            $table->float('price_per_unit');
            $table->integer('total_piece'); // Quantity
            $table->float('discount_percentage')->nullable();
            $table->integer('total_amount');
            $table->boolean('is_approved')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requistion_products');
    }
};
