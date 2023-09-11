<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('name')->index();
            $table->double('selling_price');
            $table->double('buying_price');
            $table->string('salt_composition');
            $table->text('description')->nullable();
            $table->text('side_effects')->nullable();
            $table->integer('quantity');
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('medicines');
    }
};
