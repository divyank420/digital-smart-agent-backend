<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            INSERT INTO rm_monthly_amounts_history
            (rm_id, monthly_amount, installment_amount, effective_month, effective_year, created_at, updated_at)
            SELECT 
                id,
                monthly_amount,
                installment_amount,
                MONTH(created_at),
                YEAR(created_at),
                NOW(),
                NOW()
            FROM saving_rms
        ");
    }

    public function down(): void
    {
        DB::table('rm_monthly_amounts_history')->truncate();
    }
};
