<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('sms_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        DB::table('sms_providers')->insert([
             [
                'name' => 'Exchange',
                'slug' => 'exchange',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Africa Is Talking',
                'slug' => 'africa_is_talking',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Infobip',
                'slug' => 'infobip',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Twilio',
                'slug' => 'twilio',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Termii',
                'slug' => 'termii',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_providers');
    }
};
