<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos__products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pos_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('medicine_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('product_name');
            $table->integer('product_quantity');
            $table->integer('product_total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pos__products');
    }
};
