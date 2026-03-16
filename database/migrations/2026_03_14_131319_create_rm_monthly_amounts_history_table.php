<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rm_monthly_amounts_history', function (Blueprint $table) {
            $table->id();
            $table->integer('rm_id');

            $table->decimal('monthly_amount', 10,0);
            $table->decimal('installment_amount', 10,0)->nullable();

            $table->integer('effective_month');
            $table->integer('effective_year');
            $table->boolean('status')->default(1)->comment('1 = active, 0 = inactive');

            $table->timestamps();
            $table->foreign('rm_id')
                ->references('id')
                ->on('saving_rms')
                ->onDelete('cascade');

            // Index for fast lookup
            $table->index(['rm_id', 'effective_year', 'effective_month'], 'rm_amount_effective_idx');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rm_monthly_amounts_history');
    }
};
