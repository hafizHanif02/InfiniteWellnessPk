<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pos', function (Blueprint $table) {
            $table->id()->startingValue(1210);
            $table->foreignId('prescription_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('total_amount');
            $table->integer('pos_fees');
            $table->integer('total_amount_ex_saletax')->nullable();
            $table->integer('total_amount_inc_saletax')->nullable();
            $table->integer('total_discount')->nullable();
            $table->integer('total_saletax')->nullable();
            $table->string('patient_name');
            $table->string('doctor_name')->nullable();
            $table->date('pos_date');
            $table->integer('is_paid')->nullable();
            $table->integer('is_cash')->nullable();
            $table->integer('enter_payment_amount')->nullable();
            $table->integer('change_amount')->nullable();
            $table->integer('card_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pos');
    }
};
