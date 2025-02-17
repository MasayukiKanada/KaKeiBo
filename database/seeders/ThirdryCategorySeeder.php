<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThirdryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('thirdry_categories')->insert([
            [
                'name' => 'スーパー',
                'secondary_category_id' => 6,
            ],
            [
                'name' => '食費（その他）',
                'secondary_category_id' => 6,
            ],
            [
                'name' => 'ドラッグストア',
                'secondary_category_id' => 8,
            ],
            [
                'name' => '日用品（その他）',
                'secondary_category_id' => 8,
            ],
            [
                'name' => '介護',
                'secondary_category_id' => 9,
            ],
            [
                'name' => '通院',
                'secondary_category_id' => 9,
            ],
            [
                'name' => '入院',
                'secondary_category_id' => 9,
            ],
            [
                'name' => '薬',
                'secondary_category_id' => 9,
            ],
            [
                'name' => '水道',
                'secondary_category_id' => 14,
            ],
            [
                'name' => '光熱費',
                'secondary_category_id' => 14,
            ],
            [
                'name' => '交通費',
                'secondary_category_id' => 17,
            ],
            [
                'name' => 'ガソリン代',
                'secondary_category_id' => 17,
            ],
            [
                'name' => '修繕費他',
                'secondary_category_id' => 17,
            ],
            [
                'name' => '宿泊費',
                'secondary_category_id' => 21,
            ],
            [
                'name' => 'お土産代',
                'secondary_category_id' => 21,
            ],
        ]);
    }
}
