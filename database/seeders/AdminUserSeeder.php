<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->where('role', 'admin')->delete();
        
        User::updateOrCreate(
            ['email' => 'admin@traffic-violations.com'],
            [
                'name' => 'Admininistrator',
                'password' => Hash::make('password123'), // change to a secure password
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'simplyniceweb@gmail.com'],
            [
                'name' => 'Reporter',
                'password' => Hash::make('password'), // change to a secure password
                'role' => 'reporter',
            ]
        );
    }
}
