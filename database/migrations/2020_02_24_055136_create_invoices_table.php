<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_id');
            $table->date('invoice_date')->index();
            $table->double('amount', 8, 2)->default(0);
            $table->double('discount', 8, 2)->default(0);
            $table->boolean('status')->default(0);
            $table->string('currency_symbol')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('invoices');
    }
};
