<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ledgers')->insert([
            'name' => 'General Ledger',
            'balance' => 0.00,
            'code' => 'GL001',
            'user_id' => null,
            'admin_id' => 1, // Assuming admin ID 1 is the one initializing the ledger
            'amount' => 0.00,
            'type' => 'credit',
            'opening_balance' => 0.00,
            'closing_balance' => 0.00,
            'description' => 'First Commit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
