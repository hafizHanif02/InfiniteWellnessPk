<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosage_id')->constrained()->cascadeOnDelete();
            $table->foreignId('generic_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('manufacturer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->integer('code');
            $table->string('product_name');
            $table->string('package_detail')->nullable();
            $table->tinyInteger('least_unit');
            $table->integer('trade_price_percentage');
            $table->integer('number_of_pack');
            $table->integer('pieces_per_pack');
            $table->integer('packing');
            $table->float('trade_price');
            $table->float('unit_retail');
            $table->integer('fixed_discount')->nullable();
            $table->integer('manufacturer_retail_price');
            $table->float('unit_trade');
            $table->integer('sale_tax')->nullable();
            $table->float('discount_trade_price');
            $table->integer('cost_price');
            $table->bigInteger('barcode')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_ins');
    }
};
