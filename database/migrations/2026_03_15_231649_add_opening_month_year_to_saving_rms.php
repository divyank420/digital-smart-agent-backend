<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('saving_rms', function (Blueprint $table) {
            $table->integer('opening_month')->nullable()->after('opening_balance');
            $table->integer('opening_year')->nullable()->after('opening_month');

        });

        // Fill existing records from created_at
        DB::statement("
            UPDATE saving_rms
            SET
                opening_month = MONTH(created_at),
                opening_year = YEAR(created_at)
            WHERE created_at IS NOT NULL
        ");
    }

    public function down(): void
    {
        Schema::table('saving_rms', function (Blueprint $table) {

            $table->dropColumn(['opening_month','opening_year']);

        });
    }
};