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
        Schema::create('scheduled_messages', function (Blueprint $table) {
            $table->id();

            
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sms_sender_id')->constrained()->onDelete('cascade');
            $table->string('sender');
            $table->string('description')->nullable();
            $table->string('page_number');
            $table->string('page_rate');
            $table->text('message');
            $table->enum('status', ['pending', 'sent', 'failed', 'cancel', 'delete'])->default('pending');
            $table->decimal('amount', 15, 2);
            $table->json('destination');
            $table->string('route');
            $table->dateTime('scheduled_time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduled_messages');
    }
};
