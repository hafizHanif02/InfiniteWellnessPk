<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('document_types');
    }
};
