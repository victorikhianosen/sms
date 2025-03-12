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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->foreignId('message_id')->nullable()->constrained('messages')->cascadeOnDelete();
            $table->foreignId('payment_id')->nullable()->constrained('payments')->cascadeOnDelete();
            $table->foreignId('general_ledger_id')->constrained('general_ledgers')->cascadeOnDelete();
            $table->foreignId('scheduled_message_id')->nullable()->constrained('scheduled_messages')->cascadeOnDelete(); // Add this line

            $table->decimal('amount', 15, 2);
            $table->string('transaction_type');
            $table->string('payment_method')->nullable();
            $table->decimal('balance_before', 15, 2)->nullable();
            $table->decimal('balance_after', 15, 2)->nullable();
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['success', 'failed', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
