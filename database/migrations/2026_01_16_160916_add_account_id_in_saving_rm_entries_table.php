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
        if(!Schema::hasColumn('saving_rm_entries','account_id')){
            Schema::table('saving_rm_entries', function (Blueprint $table) {
                $table->integer('account_id')->after('rm_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('saving_rm_entries','account_id')){
            Schema::table('saving_rm_entries', function (Blueprint $table) {
                $table->dropColumn('account_id');
            });
        }
    }
};
