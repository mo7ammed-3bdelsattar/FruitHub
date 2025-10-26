<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Driver;
use App\Models\OrderTracking;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'order_number'=> "ORD".Carbon::now()->year.fake()->numberBetween(10,99),
            'user_id' => 3,
            'address_id' => 3,
            'driver_id'=>Driver::factory(),
            'total_price' => fake()->numberBetween(200, 1000),
            'subtotal_price' => fake()->numberBetween(150, 900),
            'status' => fake()->randomElement(['taken','preparing','delivering','received']),
            'payment_method' => 'online',
            'payment_status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            $order->orderTrackings()->save(OrderTracking::factory()->make());
        });
    }
}
