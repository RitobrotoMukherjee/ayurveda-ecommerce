<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tax;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taxes = [
            [
                'company_registered_name' => 'Sree Krishna Ayurveda',
                'tax_name' => 'GST',
                'taxation_number' => '12ABCDG123456ZX12',
                'tax_percentage' => 18.00
            ]
        ];
        
        foreach ($taxes as $tax) {
            Tax::create($tax);
        }
    }
}
