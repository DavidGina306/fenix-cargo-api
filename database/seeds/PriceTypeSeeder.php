<?php

use App\Models\PriceType;
use Illuminate\Database\Seeder;

class PriceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feeTypes = [
            [
                'name' => 'Dolar'
            ],
            [
                'name' => 'Real'
            ],
            [
                'name' => 'Euro'
            ],
            [
                'name' => 'Peso'
            ],
            [
                'name' => 'Libra'
            ]
        ];

        foreach ($feeTypes as $item) {
           PriceType::query()->firstOrCreate($item);
        }
    }
}
