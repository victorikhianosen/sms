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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('api_key')->nullable()->unique();
            $table->string('api_secret')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->decimal('balance', 15, 2)->default('0.00');
            $table->string('last_payment_reference')->nullable();
            // $table->string('status')->default('active');
            $table->enum('status', ['active', 'inactive', 'pending', 'cancel', 'delete'])->default('active')->nullable();


            $table->string('profile_picture')->nullable();
            $table->string('valid_id')->nullable();
            $table->string('account_number')->nullable();

            $table->string('phone')->unique();
            $table->string('address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('otp')->nullable();
            $table->string('otp_expired_at')->nullable();
            $table->string('sms_rate')->default('3.00');
            $table->string('sms_char_limit')->default('150');

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
