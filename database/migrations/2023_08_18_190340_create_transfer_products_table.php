<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('unit_of_measurement');
            $table->float('price_per_unit');
            $table->integer('total_piece');
            $table->integer('total_pack');
            $table->float('amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_products');
    }
};
