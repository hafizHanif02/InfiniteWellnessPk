<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('charge_category_id')->constrained()->cascadeOnDelete();
            $table->integer('charge_type');
            $table->string('code')->index();
            $table->bigInteger('standard_charge');
            $table->text('description')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('charges');
    }
};
