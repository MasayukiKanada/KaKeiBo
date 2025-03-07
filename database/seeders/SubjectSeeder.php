<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subjects')->insert([
            [
                'name' => 'しんのすけ',
            ],
            [
                'name' => 'みさえ',
            ],
            [
                'name' => 'ひろし',
            ],
            [
                'name' => 'ひまわり',
            ],
            [
                'name' => 'シロ',
            ],
            [
                'name' => 'むさえ',
            ],
        ]);
    }
}
