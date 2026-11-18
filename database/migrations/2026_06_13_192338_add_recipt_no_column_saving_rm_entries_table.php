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
        if (!Schema::hasColumn('saving_rm_entries', 'recipt_no')) {
            Schema::table('saving_rm_entries', function (Blueprint $table) {
                $table->date('recipt_no')->nullable()->after('amount');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('saving_rm_entries', 'recipt_no')) {
            Schema::table('saving_rm_entries', function (Blueprint $table) {
                $table->dropColumn('recipt_no');
            });
        }
    }
};
