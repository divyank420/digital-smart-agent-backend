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
        Schema::create('saving_sub_rm_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('entry_id');
            $table->unsignedBigInteger('rm_id');
            $table->enum('account_type',['cash','online']);
            $table->integer('amount');
            $table->integer('payment_month');
            $table->integer('payment_year');
            $table->date('entry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('saving_sub_rm_entries');
    }
};
