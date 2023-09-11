<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('good_receive_notes', function (Blueprint $table) {
            $table->id()->startingValue(6160);
            $table->foreignId('requistion_id')->constrained()->cascadeOnDelete();
            $table->string('remark')->nullable();
            $table->date('date');
            $table->float('total_amount')->nullable();
            $table->float('total_discount_amount')->nullable();
            $table->float('net_total_amount')->nullable();
            $table->integer('advance_tax_percentage')->nullable();
            $table->float('sale_tax_percentage')->nullable();
            $table->boolean('is_approved')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('good_receive_notes');
    }
};
