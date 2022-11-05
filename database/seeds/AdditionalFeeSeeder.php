<?php

use App\Models\AdditionalFee;
use Illuminate\Database\Seeder;

class AdditionalFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $additionalFees = [
            [
                'name' => 'Papelao',
                'value' => 10
            ],
            [
                'name' => 'Embalagem Plástica',
                'value' => 30
            ]
        ];

        foreach ($additionalFees as $item) {
           AdditionalFee::query()->firstOrCreate($item);
        }
    }
}
