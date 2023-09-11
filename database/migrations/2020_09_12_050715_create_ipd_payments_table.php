<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipd_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ipd_patient_department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('amount');
            $table->date('date');
            $table->tinyInteger('payment_mode');
            $table->text('notes')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ipd_payments');
    }
};
