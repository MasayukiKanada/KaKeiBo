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

            $secondary_category_id = $this->faker->numberBetween(1, 5);

            return [
                'primary_category_id' => $primary_category_id,
                'date' => $this->faker->dateTimeBetween('-4year', '-1day'),
                'partner_id' => $this->faker->numberBetween(1, 5),
                'secondary_category_id' => $secondary_category_id,
                'subject_id' => $this->faker->numberBetween(1, 6),
                'price' => $this->faker->numberBetween(300, 10000),
                'memo' => $this->faker->realText(20),
                'sort_order' => $this->faker->numberBetween(0, 10),
                'user_id' => 2,
            ];

        } else {

            $secondary_category_id = $this->faker->numberBetween(6, 22);

            if($secondary_category_id == 6) {

                return [
                    'primary_category_id' => $primary_category_id,
                    'date' => $this->faker->dateTimeBetween('-4year', '-1day'),
                    'partner_id' => $this->faker->numberBetween(6, 10),
                    'secondary_category_id' => $secondary_category_id,
                    'thirdry_category_id' => $this->faker->numberBetween(1, 2),
                    'subject_id' => $this->faker->numberBetween(1, 6),
                    'price' => $this->faker->numberBetween(300, 10000),
                    'memo' => $this->faker->realText(20),
                    'sort_order' => $this->faker->numberBetween(0, 10),
                    'user_id' => 2,
                ];

            } elseif ($secondary_category_id == 8) {

                return [
                    'primary_category_id' => $primary_category_id,
                    'date' => $this->faker->dateTimeBetween('-4year', '-1day'),
                    'partner_id' => $this->faker->numberBetween(6, 10),
                    'secondary_category_id' => $secondary_category_id,
                    'thirdry_category_id' => $this->faker->numberBetween(3, 4),
                    'subject_id' => $this->faker->numberBetween(1, 6),
                    'price' => $this->faker->numberBetween(300, 10000),
                    'memo' => $this->faker->realText(20),
                    'sort_order' => $this->faker->numberBetween(0, 10),
                    'user_id' => 2,
                ];

            } elseif ($secondary_category_id == 9) {

                return [
                    'primary_category_id' => $primary_category_id,
                    'date' => $this->faker->dateTimeBetween('-4year', '-1day'),
                    'partner_id' => $this->faker->numberBetween(6, 10),
                    'secondary_category_id' => $secondary_category_id,
                    'thirdry_category_id' => $this->faker->numberBetween(5, 8),
                    'subject_id' => $this->faker->numberBetween(1, 6),
                    'price' => $this->faker->numberBetween(300, 10000),
                    'memo' => $this->faker->realText(20),
                    'sort_order' => $this->faker->numberBetween(0, 10),
                    'user_id' => 2,
                ];

            } elseif ($secondary_category_id == 14) {

                return [
                    'primary_category_id' => $primary_category_id,
                    'date' => $this->faker->dateTimeBetween('-4year', '-1day'),
                    'partner_id' => $this->faker->numberBetween(6, 10),
                    'secondary_category_id' => $secondary_category_id,
                    'thirdry_category_id' => $this->faker->numberBetween(9, 10),
                    'subject_id' => $this->faker->numberBetween(1, 6),
                    'price' => $this->faker->numberBetween(300, 10000),
                    'memo' => $this->faker->realText(20),
                    'sort_order' => $this->faker->numberBetween(0, 10),
                    'user_id' => 2,
                ];

            } elseif ($secondary_category_id == 17) {

                return [
                    'primary_category_id' => $primary_category_id,
                    'date' => $this->faker->dateTimeBetween('-4year', '-1day'),
                    'partner_id' => $this->faker->numberBetween(6, 10),
                    'secondary_category_id' => $secondary_category_id,
                    'thirdry_category_id' => $this->faker->numberBetween(11, 13),
                    'subject_id' => $this->faker->numberBetween(1, 6),
                    'price' => $this->faker->numberBetween(300, 10000),
                    'memo' => $this->faker->realText(20),
                    'sort_order' => $this->faker->numberBetween(0, 10),
                    'user_id' => 2,
                ];

            } elseif ($secondary_category_id == 18) {

                return [
                    'primary_category_id' => $primary_category_id,
                    'date' => $this->faker->dateTimeBetween('-4year', '-1day'),
                    'partner_id' => $this->faker->numberBetween(6, 10),
                    'secondary_category_id' => $secondary_category_id,
                    'thirdry_category_id' => $this->faker->numberBetween(14, 15),
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
                    'secondary_category_id' => $secondary_category_id,
                    'subject_id' => $this->faker->numberBetween(1, 6),
                    'price' => $this->faker->numberBetween(300, 10000),
                    'memo' => $this->faker->realText(20),
                    'sort_order' => $this->faker->numberBetween(0, 10),
                    'user_id' => 2,
                ];

            }
        }
    }
}
