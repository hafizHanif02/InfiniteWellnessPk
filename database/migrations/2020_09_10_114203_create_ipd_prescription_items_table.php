<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipd_prescription_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ipd_prescription_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('medicine_id');
            $table->string('dosage');
            $table->text('instruction');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ipd_prescription_items');
    }
};
