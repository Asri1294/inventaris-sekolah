<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Administrator', 'email' => 'admin@sekolah.test', 'role' => 'admin'],
            ['name' => 'Maya', 'email' => 'maya@sekolah.test', 'role' => 'user'],
            ['name' => 'Ratih', 'email' => 'ratih@sekolah.test', 'role' => 'user'],
        ];

        foreach ($users as $data) {
            User::forceCreate($data + [
                'password' => 'password',
                'email_verified_at' => now(),
            ]);
        }
    }
}
