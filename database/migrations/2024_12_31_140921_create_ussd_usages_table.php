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
        Schema::create('ussd_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('ussd_shortcode_id')->nullable()->constrained('ussd_shortcodes')->cascadeOnDelete();
            $table->foreignId('mobile_network_id')->nullable()->constrained('mobile_networks')->cascadeOnDelete();
            $table->integer('ussd_count')->nullable();
            $table->decimal('amount_charged', 15, 2)->nullable();
            $table->decimal('opening_balance', 15, 2)->nullable();
            $table->decimal('closing_balance', 15, 2)->nullable();
            $table->decimal('session_charged', 15, 2)->nullable();
            $table->date('usage_date')->nullable();
            $table->decimal('amount_credited', 15, 2)->nullable();
            $table->string('trans_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ussd_usages');
    }
};
