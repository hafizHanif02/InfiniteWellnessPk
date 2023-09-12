<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requistions', function (Blueprint $table) {
            $table->id()->startingValue(95000);
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->string('remarks')->nullable();
            $table->date('delivery_date')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->date('purchase_order_date')->nullable();
            $table->float('discount_amount')->nullable();
            $table->boolean('is_updated')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requistions');
    }
};
