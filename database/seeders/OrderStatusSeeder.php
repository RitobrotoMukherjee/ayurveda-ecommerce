<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'status' => 'Initiated'
            ],
            [
                'status' => 'Paid'
            ],
            [
                'status' => 'Cancelled'
            ]
        ];
        
        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
}
