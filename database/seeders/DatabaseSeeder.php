<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PrimaryCategory;
use App\Models\ThirdryCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'user',
            'email' => 'test@test.com',
        ]);

        $this->call([
            PrimaryCategorySeeder::class,
            SecondaryCategorySeeder::class,
            ThirdryCategorySeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
        \App\Models\Item::factory(10)->create();\App\Models\Partner::factory(10)->create();
        \App\Models\Subject::factory(10)->create();
    }
}
