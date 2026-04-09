<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MigrateCreatedAtToExpensesDateInSavingExpensesTable extends Migration
{
    public function up()
    {
        if (
            Schema::hasColumn('saving_expenses', 'created_at') &&
            Schema::hasColumn('saving_expenses', 'expenses_date')
        ) {
            DB::table('saving_expenses')
                ->whereNull('expenses_date')
                ->update([
                    'expenses_date' => DB::raw('DATE(created_at)')
                ]);
        }
    }

    public function down()
    {
        if (Schema::hasColumn('saving_expenses', 'expenses_date')) {
            DB::table('saving_expenses')->update([
                'expenses_date' => null
            ]);
        }
    }
}
