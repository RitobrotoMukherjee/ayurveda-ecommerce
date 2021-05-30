<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->sentence(4, true).'-'.rand(1, 100);
        return [
            'product_category_id' => rand(1,4),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'featured' => rand(0 ,1),
            'available' => rand(0, 5),
            'price' => (float)rand(100, 1000),
            'discount' => (float)rand(10, 90)
        ];
    }
}
