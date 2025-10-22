<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Tag::all()->each(function ($tag) {
            $tag->products()->attach(
                \App\Models\Product::inRandomOrder()->take(rand(1, 5))->pluck('id')->toArray()            );
        });
    }
}
