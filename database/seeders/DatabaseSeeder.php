<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\PrimaryCategory;
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
        $this->call([
            PrimaryCategorySeeder::class,
            SecondaryCategorySeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
        \App\Models\Item::factory(10)->create();\App\Models\Partner::factory(10)->create();
        \App\Models\Subject::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
