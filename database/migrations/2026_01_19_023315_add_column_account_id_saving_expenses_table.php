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
        if(!Schema::hasColumn('saving_expenses','account_id')){
            Schema::table('saving_expenses', function (Blueprint $table) {
                $table->integer('account_id')->nullable()->after('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('saving_expenses','account_id')){
            Schema::table('saving_expenses', function (Blueprint $table) {
                $table->dropColumn('account_id');
            });
        }
    }
};
