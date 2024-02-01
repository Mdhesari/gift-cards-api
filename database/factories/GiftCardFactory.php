<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GiftCard>
 */
class GiftCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code'              => $this->faker->unique()->word,
            'remaining_balance' => $this->faker->randomFloat(2, 10, 1000),
            'max_users'         => $this->faker->numberBetween(50, 200),
            'used_count'        => $this->faker->numberBetween(0, 50),
            'quantity'          => $this->faker->numberBetween(1, 10),
        ];
    }
}
