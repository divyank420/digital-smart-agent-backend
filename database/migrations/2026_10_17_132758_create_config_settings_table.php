<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('config_settings', function (Blueprint $table) {
            $table->id();
            $table->string('config_key', 100)->unique();
            $table->string('category', 50)->nullable()->default('general')->comment('E.g., company, software, general');
            $table->string('label', 150);
            $table->string('type', 30)->comment('boolean, text, number, select, radio, checkbox, multi_select, checkbox_group, textarea, date, time, month_year');
            $table->json('default_value');
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->boolean('is_removable')->default(true);
            $table->boolean('is_active')->default(true);
            $table->text('message')->nullable();
            $table->string('access_level', 20)->default('all')->comment('all, owner');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('config_settings');
    }
};
