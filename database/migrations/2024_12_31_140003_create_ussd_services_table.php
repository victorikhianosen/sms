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
        Schema::create('ussd_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constraint('user_id')->cascadeOnDelete();
            $table->string('name');
            $table->string('service_code');
            $table->string('resource_type');
            $table->string('resource_class');
            $table->string('resource_url');
            $table->string('status');
            $table->string('naration');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ussd_services');
    }
};
