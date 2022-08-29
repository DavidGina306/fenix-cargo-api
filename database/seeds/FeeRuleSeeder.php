<?php

use App\Models\FeeRule;
use Illuminate\Database\Seeder;

class FeeRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $feeRules = [
            [
                'name' => 'Taxa Minima'
            ],
            [
                'name' => 'Excedente fixo por kg'
            ],
            [
                'name' => 'Excedente variável por peso'
            ],
            [
                'name' => 'Taxa fixa por kg'
            ]
        ];

        foreach ($feeRules as $item) {
           FeeRule::query()->firstOrCreate($item);
        }
    }
}
