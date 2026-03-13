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
        if(!Schema::hasColumn('saving_rms','rm_id')){
            Schema::table('saving_rms', function (Blueprint $table) {
                $table->integer('rm_id')->nullable()->after('customer_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('saving_rms','rm_id')){
            Schema::table('saving_rms', function (Blueprint $table) {
                $table->dropColumn('rm_id');
            });
        }
    }
};
