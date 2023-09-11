<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipd_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ipd_patient_department_id')->constrained()->cascadeOnDelete();
            $table->integer('total_charges');
            $table->integer('total_payments');
            $table->integer('gross_total');
            $table->integer('discount_in_percentage');
            $table->integer('tax_in_percentage');
            $table->integer('other_charges');
            $table->integer('net_payable_amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ipd_bills');
    }
};
