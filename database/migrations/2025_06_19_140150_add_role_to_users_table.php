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
    Schema::table('users', function (Blueprint $table) {
    // Wklej tę linię
    $table->string('role')->default('user'); // Domyślnie każdy nowy użytkownik ma rolę 'user'
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('users', function (Blueprint $table) {
    // Wklej tę linię
    $table->dropColumn('role');
    });
    }
};
