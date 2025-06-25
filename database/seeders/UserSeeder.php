<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'uuid' => Str::uuid(),
            'name' => 'Partner',
            'lastname' => 'Main',
            'user_type' => 'partner',
            'phone' => '0700000000',
            'role_id' => 1,
            'email' => 'partner@main.com',
            'password' => Hash::make('password123'),
            'token' => null,
            'last_login' => now(),
            'is_logged_in' => false,
            'email_verified_at' => now(),
        ]);
    }
}
