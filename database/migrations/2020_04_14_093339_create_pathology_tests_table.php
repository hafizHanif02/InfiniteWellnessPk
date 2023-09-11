<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pathology_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('charge_category_id')->constrained()->cascadeOnDelete();
            $table->string('test_name')->index();
            $table->string('short_name');
            $table->string('test_type');
            $table->integer('unit')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('method')->nullable();
            $table->integer('report_days')->nullable();
            $table->integer('standard_charge');
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pathology_tests');
    }
};
