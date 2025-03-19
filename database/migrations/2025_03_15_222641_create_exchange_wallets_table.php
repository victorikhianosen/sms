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
        Schema::create('exchange_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('route')->unique();
            $table->bigInteger('total_unit')->default(0);
            $table->bigInteger('available_unit')->default(0);
            $table->decimal('rate', 15, 2)->default(0.00);
            $table->decimal('total_balance', 15, 2)->default(0.00);
            $table->decimal('available_balance', 15, 2)->default(0.00);
            $table->string('status');
            $table->longText('description')->nullable();
            $table->timestamps();
        });


        DB::table('exchange_wallets')->insert([
            [
                'name' => 'Transactional',
                'username' => 'ggttxmt',
                'route' => 'exchange_trans',
                'total_unit' => '0.00',
                'available_unit' => '0.00',
                'rate' => '2.90',
                'total_balance' => '0.00',
                'available_balance' => '0.00',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Promotional',
                'username' => 'ggtprmt',
                'route' => 'exchange_pro',
                'total_unit' => '0.00',
                'available_unit' => '0.00',
                'rate' => '2.50',
                'total_balance' => '0.00',
                'available_balance' => '0.00',
                'status' => 'active',
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
        Schema::dropIfExists('exchange_wallets');
    }
};
