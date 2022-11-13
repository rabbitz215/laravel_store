<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'balance' => 50000000,
            'password' => bcrypt('ljtjdhgb21')
        ]);

        $admin->assignRole('admin');

        $admin2 = User::create([
            'name' => 'Admin2',
            'email' => 'galang@example.com',
            'balance' => 50000000,
            'password' => bcrypt('ljtjdhgb21')
        ]);

        $admin2->assignRole('admin');

        $moderator = User::create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'balance' => 50000000,
            'password' => bcrypt('ljtjdhgb21')
        ]);

        $moderator->assignRole('moderator');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'balance' => 1000000,
            'password' => bcrypt('ljtjdhgb21')
        ]);

        $user->assignRole('user');
    }
}
