<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasColumn('saving_customers', 'profile_image')) {
            Schema::table('saving_customers', function (Blueprint $table) {
                $table->date('profile_image')->nullable()->after('rm_code');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('saving_customers', 'profile_image')) {
            Schema::table('saving_customers', function (Blueprint $table) {
                $table->dropColumn('profile_image');
            });
        }
    }
};
