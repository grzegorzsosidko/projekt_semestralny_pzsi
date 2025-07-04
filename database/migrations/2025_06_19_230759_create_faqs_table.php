<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('faqs', function (Blueprint $table) {
    $table->id();
    $table->text('question');
    $table->text('answer');
    $table->boolean('is_hidden')->default(false); // Domyślnie każde pytanie jest widoczne
    $table->timestamps();
    });
    }

    public function down(): void
    {
    Schema::dropIfExists('faqs');
    }
};
