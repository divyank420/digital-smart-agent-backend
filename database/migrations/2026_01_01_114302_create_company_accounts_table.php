<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('saving_company_accounts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('company_id');
            $table->string('account_holder_name');
            $table->string('bank_name');

            // Account type (India standard)
            $table->enum('account_type', ['saving', 'current', 'cash', 'upi'])
                ->default('saving');

            // Financials
            $table->decimal('opening_balance', 15, 2)->default(0);
            $table->decimal('current_balance', 15, 2)->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saving_company_accounts');
    }
};
