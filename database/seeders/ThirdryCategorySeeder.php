<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ThirdryCategorySeeder extends Seeder
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
                'name' => 'スーパー',
                'secondary_category_id' => 1,
            ],
            [
                'name' => '食費（その他）',
                'secondary_category_id' => 1,
            ],
            [
                'name' => 'ドラッグストア',
                'secondary_category_id' => 3,
            ],
            [
                'name' => '日用品（その他）',
                'secondary_category_id' => 3,
            ],
            [
                'name' => '介護',
                'secondary_category_id' => 4,
            ],
            [
                'name' => '通院',
                'secondary_category_id' => 4,
            ],
            [
                'name' => '入院',
                'secondary_category_id' => 4,
            ],
            [
                'name' => '薬',
                'secondary_category_id' => 4,
            ],
            [
                'name' => '水道',
                'secondary_category_id' => 9,
            ],
            [
                'name' => '光熱費',
                'secondary_category_id' => 9,
            ],
            [
                'name' => '交通費',
                'secondary_category_id' => 12,
            ],
            [
                'name' => 'ガソリン代',
                'secondary_category_id' => 12,
            ],
            [
                'name' => '修繕費他',
                'secondary_category_id' => 12,
            ],
            [
                'name' => '宿泊費',
                'secondary_category_id' => 13,
            ],
            [
                'name' => 'お土産代',
                'secondary_category_id' => 13,
            ],
        ]);
    }
}
