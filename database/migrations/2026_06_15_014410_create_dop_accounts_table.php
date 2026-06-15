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
        Schema::create('dop_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->index();

            $table->string('account_no', 30)->unique(); 
            $table->string('account_name', 150);
            $table->string('sort_code', 20)->nullable();
            $table->decimal('monthly_amount', 12, 2)->default(0.00);
            $table->integer('total_paid_installment')->default(0);

            $table->date('account_opening_date')->nullable();
            $table->date('last_deposit_date')->nullable();
            $table->date('maturity_date')->nullable();
            $table->string('maturity_status', 50)->default('Active');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dop_accounts');
    }
};
