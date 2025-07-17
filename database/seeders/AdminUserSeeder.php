<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@notaris.com'],
            [
                'name' => 'Admin Notaris',
                'email' => 'admin@notaris.com',
                'password' => Hash::make('password'), // Ganti jika perlu
                'role' => 'admin',
            ]
        );
    }
}