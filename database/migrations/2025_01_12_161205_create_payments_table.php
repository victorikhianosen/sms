<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete();

            $table->decimal('amount', 15, 2);
            $table->string('status')->default('pending');
            $table->string('transaction_number')->unique();
            $table->string('reference')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();

            $table->string('card_last_four')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('currency')->default('naira');

            $table->json('paystack_response')->nullable();
            $table->json('verify_response')->nullable();

            $table->string('description')->nullable();
            $table->enum('payment_type', ['debit', 'credit', 'failed'])->nullable();
            $table->string('payment_method');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
