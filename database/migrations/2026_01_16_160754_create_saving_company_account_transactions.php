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
        Schema::create('saving_account_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            // Polymorphic relation (Entry, Expense, etc.)
            // Polymorphic relation (manual to control index name)
            $table->unsignedBigInteger('transactionable_id');
            $table->string('transactionable_type');
            // Transaction type
            $table->enum('transaction_type', ['credit', 'debit']);
            // Amount
            $table->decimal('amount', 15, 2);
            // Balance after transaction (important for audit)
            $table->decimal('balance_after', 15, 2);
            $table->string('reference_no')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_account_transactions');
    }
};
