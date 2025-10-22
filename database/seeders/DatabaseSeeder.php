<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\SettingSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ProductTagSeeder;
use Database\Seeders\CartProductSeeder;
use Database\Seeders\OrderProductSeeder;
use Database\Seeders\RolePermissionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        \App\Models\Tag::factory(10)->create();
        $this->call([
            RolePermissionSeeder::class,
        ]);
        
        \App\Models\Category::factory(5)->has(Product::factory()->count(5))->create();

        
        Order::factory(1)->create();


        $this->call([
            SettingSeeder::class,
            CartProductSeeder::class,
            OrderProductSeeder::class,
            ProductTagSeeder::class,
        ]);

    }
}
