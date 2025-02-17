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
        return [
            'primary_category_id' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date,
            'partner_id' => $this->faker->numberBetween(1, 10),
            'secondary_category_id' => $this->faker->numberBetween(1, 10),
            'thirdry_category_id' => $this->faker->numberBetween(1, 10),
            'subject_id' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(300, 10000),
            'memo' => $this->faker->realText(20),
            'sort_order' => $this->faker->numberBetween(0, 10),
            'user' => 1,
        ];
    }
}
