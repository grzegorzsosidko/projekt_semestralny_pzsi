<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // ścieżka: database/migrations/xxxx_xx_xx_xxxxxx_add_blocked_at_to_users_table.php

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Dodajemy kolumnę, która może być pusta (null)
            $table->timestamp('blocked_at')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('blocked_at');
        });
    }
};
