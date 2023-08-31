<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an "admin" user
        DB::table('users')->insert([
            'firstname' => 'Admin',
            'lastname' => 'User',
            'email' => 'admin@lnu.edu.ph',
            'role_id' => 3, // Admin role ID
            'url' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('Admin123!'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'verified' => true,
        ]);

        // Create a "super-admin" user
        DB::table('users')->insert([
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'email' => 'superadmin@lnu.edu.ph',
            'role_id' => 4, // Super Admin role ID
            'url' => null,
            'email_verified_at' => now(),
            'password' => Hash::make('Superadmin123!'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'verified' => true,
        ]);
    }
}
