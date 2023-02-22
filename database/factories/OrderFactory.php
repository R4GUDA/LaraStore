<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'delivery_date' => $this->faker->date,
            'email' => $this->faker->email,
            'secret' => Str::random(8),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->city,
        ];
    }
}
