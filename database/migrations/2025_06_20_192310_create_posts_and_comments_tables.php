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
        // Tworzymy tabelę 'posts' z jawnym określeniem silnika InnoDB
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // KLUCZOWA POPRAWKA
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title', 70);
            $table->string('slug')->unique();
            $table->text('intro_text');
            $table->text('subheading');
            $table->string('cover_image_path');
            $table->text('content_1')->nullable();
            $table->string('image_1_path')->nullable();
            $table->text('content_2')->nullable();
            $table->string('image_2_path')->nullable();
            $table->text('content_3')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
        });

        // Tworzymy tabelę 'comments' z tym samym silnikiem
        Schema::create('comments', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // KLUCZOWA POPRAWKA
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('posts');
    }
};
