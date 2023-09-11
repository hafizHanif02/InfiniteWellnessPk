<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('good_receive_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('good_receive_note_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('deliver_qty');
            $table->integer('bonus')->nullable()->default(0);
            $table->date('expiry_date');
            $table->float('item_amount');
            $table->integer('batch_number');
            $table->float('discount')->nullable()->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('good_receive_products');
    }
};
