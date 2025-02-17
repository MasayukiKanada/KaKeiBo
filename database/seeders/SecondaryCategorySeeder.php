<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecondaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('secondary_categories')->insert([
            [
                'name' => '給料・年金',
                'primary_category_id' => 1,
            ],
            [
                'name' => '雑所得',
                'primary_category_id' => 1,
            ],
            [
                'name' => '配当',
                'primary_category_id' => 1,
            ],
            [
                'name' => '財形',
                'primary_category_id' => 1,
            ],
            [
                'name' => '地代',
                'primary_category_id' => 1,
            ],
            [
                'name' => '食費',
                'primary_category_id' => 2,
            ],
            [
                'name' => '外食',
                'primary_category_id' => 2,
            ],
            [
                'name' => '日用品',
                'primary_category_id' => 2,
            ],
            [
                'name' => '医療費',
                'primary_category_id' => 2,
            ],
            [
                'name' => '美容',
                'primary_category_id' => 2,
            ],
            [
                'name' => '衣服',
                'primary_category_id' => 2,
            ],
            [
                'name' => '菜園用品',
                'primary_category_id' => 2,
            ],
            [
                'name' => '菓子',
                'primary_category_id' => 2,
            ],
            [
                'name' => '水道・ガス・光熱費',
                'primary_category_id' => 2,
            ],
            [
                'name' => '通信費',
                'primary_category_id' => 2,
            ],
            [
                'name' => '配送費',
                'primary_category_id' => 2,
            ],
            [
                'name' => '車両費',
                'primary_category_id' => 2,
            ],
            [
                'name' => '旅費',
                'primary_category_id' => 2,
            ],
            [
                'name' => '贈答品',
                'primary_category_id' => 2,
            ],
            [
                'name' => '催事',
                'primary_category_id' => 2,
            ],
            [
                'name' => '保険料',
                'primary_category_id' => 2,
            ],
            [
                'name' => '税金',
                'primary_category_id' => 2,
            ],
        ]);
    }
}
