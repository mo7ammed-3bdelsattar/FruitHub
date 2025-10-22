<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    // public function configure()
    // {
    //     return $this->afterCreating(function (Category $category) {
    //         $category->products()->saveMany(Product::factory(5)->make());
    //     });
    // }
}
