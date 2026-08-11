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
        if (!Schema::hasColumn('saving_expenses', 'category_id')) {
            Schema::table('saving_expenses', function (Blueprint $table) {
                $table->date('category_id')->nullable()->after('account_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('saving_expenses', 'category_id')) {
            Schema::table('saving_expenses', function (Blueprint $table) {
                $table->dropColumn('category_id');
            });
        }
    }
};
