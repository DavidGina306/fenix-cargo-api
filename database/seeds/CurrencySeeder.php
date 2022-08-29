<?php

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
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
           Currency::query()->firstOrCreate($item);
        }
    }
}
