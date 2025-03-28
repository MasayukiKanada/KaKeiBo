<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $primary_category_id = $this->faker->numberBetween(1, 2);

        if($primary_category_id == 1) {
            return [
                'primary_category_id' => $primary_category_id,
                'date' => $this->faker->dateTimeBetween('-4year', '-1day'),
                'partner_id' => $this->faker->numberBetween(1, 5),
                'secondary_category_id' => $this->faker->numberBetween(1, 5),
                'subject_id' => $this->faker->numberBetween(1, 6),
                'price' => $this->faker->numberBetween(300, 10000),
                'memo' => $this->faker->realText(20),
                'sort_order' => $this->faker->numberBetween(0, 10),
                'user_id' => 2,
            ];

        } else {
            return [
                'primary_category_id' => $primary_category_id,
                'date' => $this->faker->dateTimeBetween('-4year', '-1day'),
                'partner_id' => $this->faker->numberBetween(6, 10),
                'secondary_category_id' => $this->faker->numberBetween(6, 22),
                'subject_id' => $this->faker->numberBetween(1, 6),
                'price' => $this->faker->numberBetween(300, 10000),
                'memo' => $this->faker->realText(20),
                'sort_order' => $this->faker->numberBetween(0, 10),
                'user_id' => 2,
        ];
        }
    }
}
