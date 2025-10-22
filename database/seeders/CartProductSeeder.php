<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CartProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Cart::all()->each(function ($cart) {
            $cart->products()->attach(
                \App\Models\Product::inRandomOrder()->take(rand(1, 5))->pluck('id')->toArray(),
                ['quantity' => rand(1, 3)]
            );
        });
    }
}
