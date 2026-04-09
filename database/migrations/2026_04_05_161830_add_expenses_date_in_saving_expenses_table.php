<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpensesDateInSavingExpensesTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('saving_expenses', 'expenses_date')) {
            Schema::table('saving_expenses', function (Blueprint $table) {
                $table->date('expenses_date')->nullable()->after('reason');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('saving_expenses', 'expenses_date')) {
            Schema::table('saving_expenses', function (Blueprint $table) {
                $table->dropColumn('expenses_date');
            });
        }
    }
}
