<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id()->startingValue(7780);
            $table->foreignId('manufacturer_id')->constrained()->cascadeOnDelete();
            $table->string('account_title');
            $table->string('contact_person')->unique();
            $table->bigInteger('phone');
            $table->string('email');
            $table->string('address');
            $table->bigInteger('ntn');
            $table->integer('sales_tax_reg');
            $table->boolean('active');
            $table->string('area');
            $table->string('city');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
