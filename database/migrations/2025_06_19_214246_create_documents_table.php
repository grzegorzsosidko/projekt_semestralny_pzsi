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
    Schema::create('documents', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('doc_category_id')->constrained()->onDelete('cascade');
    $table->enum('status', ['published', 'hidden'])->default('published');
    $table->softDeletes(); // Do obsługi "miękkiego usuwania"
    $table->timestamps();
    });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
