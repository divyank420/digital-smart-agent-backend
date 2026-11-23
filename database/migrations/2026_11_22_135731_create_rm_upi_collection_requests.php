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
        Schema::create('rm_upi_collection_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->unsignedBigInteger('rm_id')->index();
            $table->unsignedBigInteger('account_id')->nullable()->index();
            $table->decimal('amount', 12, 2);
            $table->string('payee_upi_id', 100)->nullable();
            $table->string('screenshot_path', 500);
            $table->enum('status', ['Submitted', 'Approved', 'Rejected']);
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rm_upi_collection_requests');
    }
};
