<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Ayurvedic medicine'
            ],
            [
                'name' => 'Herbs'
            ],
            [
                'name' => 'Herbal Extracts'
            ],
            [
                'name' => 'Raw materials'
            ]
        ];
        
        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
