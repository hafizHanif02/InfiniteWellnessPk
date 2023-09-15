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
        Schema::create('pos_product', function (Blueprint $table) {
        $table->foreignId('pos_id')->nullable()->constrained()->cascadeOnDelete();
        $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();
        $table->string('product_name');
        $table->integer('product_quantity');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
