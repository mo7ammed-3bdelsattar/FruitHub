<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => \App\Models\City::factory(),
            'street' => fake()->streetAddress(),
            'building' => fake()->buildingNumber(),
            'apartment' => fake()->numberBetween(1, 4),
            'floor' => fake()->numberBetween(1, 20),
            'created_at' =>now(),
            'updated_at' =>now(),
        ];
    }

}
