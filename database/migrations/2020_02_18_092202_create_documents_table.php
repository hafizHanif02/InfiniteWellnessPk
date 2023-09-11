<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('document_type_id')->constrained()->cascadeOnDelete();
            $table->text('notes')->nullable();
            $table->bigInteger('uploaded_by');
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('documents');
    }
};
