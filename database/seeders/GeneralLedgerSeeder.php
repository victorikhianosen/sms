<?php

namespace Database\Seeders;

use App\Models\GeneralLedger;
use Illuminate\Database\Seeder;

class GeneralLedgerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralLedger::updateOrCreate(
            ['account_number' => '99248466'], // Ensure no duplicate account codes
            [
                'name' => 'SmsTrix',
                'balance' => 0.00, // Initial balance
                'status' => 'active',
                'description' => 'General ledger for SmsTrix',
            ]
        );
    }
}
