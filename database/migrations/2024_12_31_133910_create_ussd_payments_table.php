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
        Schema::create('ussd_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); 
            $table->string('reference', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('trace_id', 100)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('message', 500)->nullable();
            $table->string('payment_gateway', 100)->nullable();
            $table->string('payment_type', 100)->nullable();
            // $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ussd_payments');
    }
};
