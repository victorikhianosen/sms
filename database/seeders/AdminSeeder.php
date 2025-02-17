<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'first_name' => 'Victor',
                'last_name' => 'Ikhianosen',
                'email' => 'victor@ggt.com',
                'phone_number' => '07033274155',
                'password' => Hash::make('Password'),
                'role' => 'super_admin',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Seun',
                'last_name' => 'Olalani',
                'email' => 'seunolalani@ggtconnect.com',
                'phone_number' => '09033992191',
                'password' => Hash::make('x52xKVS9MDKD'),
                'role' => 'supervisor',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Support',
                'last_name' => 'Matric',
                'email' => 'support@assetmatrixmfb.com',
                'phone_number' => '08037539600',
                'password' => Hash::make('RPkm8R6WRe2R'),
                'role' => 'admin',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('admins')->upsert($admins, ['email'], ['first_name', 'last_name', 'phone_number', 'password', 'role', 'status', 'updated_at']);
    }
}
