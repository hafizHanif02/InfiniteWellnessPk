<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id()->startingValue(1010);
            $table->foreignId('dosage_id')->constrained()->cascadeOnDelete();
            $table->foreignId('generic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('manufacturer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('product_name')->unique();
            $table->string('package_detail')->nullable();
            $table->tinyInteger('unit_of_measurement');
            $table->integer('number_of_pack');
            $table->float('manufacturer_retail_price');
            $table->integer('pieces_per_pack');
            $table->integer('total_quantity');
            $table->integer('open_quantity');
            $table->float('trade_price_percentage');
            $table->float('unit_retail');
            $table->integer('fixed_discount')->nullable();
            $table->float('trade_price');
            $table->float('unit_trade');
            $table->integer('sale_tax_percentage')->nullable();
            $table->float('discount_trade_price');
            $table->float('cost_price');
            $table->bigInteger('barcode')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
