<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'ユーザー',
                'email' => 'test@test.com',
                'password' => Hash::make('password123')
            ],
            [
                'name' => 'デモユーザー',
                'email' => 'demo@demo.com',
                'password' => Hash::make('demo12345'),
            ]
        ]);
    }
}
