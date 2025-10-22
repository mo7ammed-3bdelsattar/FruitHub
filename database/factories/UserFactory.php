<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Wishlist;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'), // password
            'is_admin' => false,
            'phone' => fake()->phoneNumber,
            'gender' => fake()->numberBetween(0, 1),
            'remember_token' => Str::random(10),
            'created_at' =>now(),
            'updated_at' =>now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $user->cart()->save(Cart::factory()->make());
            $user->wishlist()->save(Wishlist::factory()->make());
            $user->addresses()->save(Address::factory()->make());
        });
    }
}
