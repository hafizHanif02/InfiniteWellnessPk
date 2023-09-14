<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_patient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formID')->nullable()->constrained()->cascadeOnDelete();
            $table->string('formName');
            $table->foreignId('patientID')->nullable()->constrained()->cascadeOnDelete();
            $table->string('formDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
