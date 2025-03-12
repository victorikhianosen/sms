<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->cascadeOnDelete();
            $table->foreignId('sms_sender_id')->constrained('sms_senders')->cascadeOnDelete();
            $table->string('sender')->nullable();
            $table->string('page_number')->nullable();
            $table->string('page_rate')->nullable();
            $table->string('status')->nullable();
            $table->string('amount')->nullable();
            $table->string('message')->nullable();
            $table->string('message_reference')->nullable();
            $table->string('transaction_number')->nullable();
            $table->string('destination')->nullable();
            $table->string('route')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
