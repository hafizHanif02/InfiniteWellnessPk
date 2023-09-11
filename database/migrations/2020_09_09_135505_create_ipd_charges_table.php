<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipd_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ipd_patient_department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('charge_category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('charge_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->integer('charge_type_id');
            $table->integer('standard_charge')->nullable();
            $table->integer('applied_charge');
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('ipd_charges');
    }
};
