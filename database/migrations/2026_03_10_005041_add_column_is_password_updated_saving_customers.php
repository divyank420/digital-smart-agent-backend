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
        if (!Schema::hasColumn('saving_customers', 'is_password_updated')) {
            Schema::table('saving_customers', function (Blueprint $table) {
                $table->integer('is_password_updated')->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('saving_customers', 'is_password_updated')) {
            Schema::table('saving_customers', function (Blueprint $table) {
                $table->dropColumn('is_password_updated');
            });
        }
    }
};
