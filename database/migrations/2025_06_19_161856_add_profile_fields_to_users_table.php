<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    // ścieżka: database/migrations/xxxx_xx_xx_xxxxxx_add_profile_fields_to_users_table.php

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('email');
            $table->string('title')->nullable()->after('name'); // np. "Specjalista IT"
            $table->text('bio')->nullable()->after('phone_number');
            $table->text('interests')->nullable()->after('bio');
            $table->string('avatar_path')->nullable()->after('interests');
            $table->string('cover_photo_path')->nullable()->after('avatar_path');
            $table->json('social_links')->nullable()->after('cover_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'title', 'bio', 'interests', 'avatar_path', 'cover_photo_path', 'social_links']);
        });
    }
};
