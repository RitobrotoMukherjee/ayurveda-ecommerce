<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProductCategorySeeder::class,
            OrderStatusSeeder::class,
            TaxSeeder::class
        ]);
         \App\Models\User::factory()->count(1)->create();
         \App\Models\Customer::factory()->count(1)->create();
         \App\Models\Product::factory()->count(15)->create();
    }
}
