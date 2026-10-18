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
        Schema::create('onboarding_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            /*
            |--------------------------------------------------------------------------
            | Step 1: Basic Information
            |--------------------------------------------------------------------------
            */
            $table->string('company_name');
            $table->string('owner_name');
            $table->string('mobile', 10)->index();
            $table->string('email')->index();
            /*
            |--------------------------------------------------------------------------
            | OTP Verification
            |--------------------------------------------------------------------------
            */
            $table->string('otp_hash')->nullable();
            $table->timestamp('otp_sent_at')
                ->nullable();
            $table->timestamp('otp_expires_at')
                ->nullable();
            $table->unsignedTinyInteger('otp_attempts')
                ->default(0);
            $table->boolean('otp_verified')
                ->default(false);
            /*
            |--------------------------------------------------------------------------
            | Step 3: Business Details
            |--------------------------------------------------------------------------
            */
            $table->unsignedInteger('dop_agents')
                ->nullable();
            $table->unsignedInteger('sub_agents')
                ->nullable();
            $table->string('post_office')
                ->nullable();
            $table->string('dop_id')
                ->nullable();
            $table->string('dop_password')
                ->nullable();
            /*
            |--------------------------------------------------------------------------
            | Plan Selection
            |--------------------------------------------------------------------------
            */
            $table->json('selected_plans')
                ->nullable();

            $table->unsignedTinyInteger('current_step')
                ->default(1);
            $table->enum('status',['started','submitted','pending','approved'])
                ->default('started'); // started, submitted, pending, approved
            $table->timestamp('expires_at')
                ->nullable();
            $table->timestamps();
            $table->index([
                'mobile',
                'status'
            ]);

            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('onboarding_requests');
    }
};
