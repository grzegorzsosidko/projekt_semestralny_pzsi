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
    Schema::table('faqs', function (Blueprint $table) {
    // Używamy nullable, aby uniknąć błędów z istniejącymi danymi
    $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('set null');
    });
    }

    public function down(): void
    {
    Schema::table('faqs', function (Blueprint $table) {
    $table->dropForeign(['user_id']);
    $table->dropColumn('user_id');
    });
    }
};
