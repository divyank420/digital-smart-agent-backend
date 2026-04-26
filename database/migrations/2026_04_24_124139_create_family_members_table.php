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
        Schema::create('saving_family_members', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->integer('company_id');
            $table->string('name');
            $table->string('relation')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('saving_customers')
                ->onDelete('cascade');

            $table->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_family_members');
    }
};
