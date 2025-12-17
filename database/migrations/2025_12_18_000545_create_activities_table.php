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
        Schema::create('saving_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            // Polymorphic target (user, entry, expense, denomination, etc.)
            $table->morphs('activityable');
            // creates: activityable_id, activityable_type
            $table->string('action', 50);
            // examples: created_user, insert_entry, update_entry, delete_entry
            $table->text('message');
            // Optional metadata (before/after values, ip, device, etc.)
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->index(['action']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_activities');
    }
};
