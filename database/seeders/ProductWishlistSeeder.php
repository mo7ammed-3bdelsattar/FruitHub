<?php

namespace Database\Seeders;

use App\Models\Wishlist;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductWishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        wishlist::all()->each(function (Wishlist $wishlist) {
            $wishlist->products()->attach(
                \App\Models\Product::inRandomOrder()->take(rand(1, 5))->pluck('id')->toArray()
            );
        });
    }
}
