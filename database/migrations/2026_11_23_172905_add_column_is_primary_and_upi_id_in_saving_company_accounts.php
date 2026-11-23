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
        Schema::table('saving_company_accounts', function (Blueprint $table) {
            $table->string('upi_id')->nullable()->after('bank_name');
            $table->boolean('is_primary')->default(false)->after('account_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saving_company_accounts', function (Blueprint $table) {
            $table->dropColumn('upi_id');
            $table->dropColumn('is_primary');
        });
    }
};
