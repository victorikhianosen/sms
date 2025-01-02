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
        Schema::create('user_shortcodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId(column: 'ussd_short_code_id')->constrained('ussd_shortcodes')->cascadeOnDelete();
            $table->foreignId(column: 'mobile_network_id')->constrained('mobile_networks')->cascadeOnDelete();
            $table->string('expire_date')->nullable();
            $table->string('billing_plan')->nullable();
            $table->decimal('session_balance', 15, 2)->nullable();
            $table->decimal('session_cost_price', 15, 2)->nullable();
            $table->decimal('session_sell_price', 15, 2)->nullable();
            $table->string(column: 'service_code')->nullable();
            $table->string('service_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_shortcodes');
    }
};
