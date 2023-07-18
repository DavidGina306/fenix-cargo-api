<?php

use App\Models\FeeType;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
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
                'name' => 'Aéreo Urgente'
            ],
            [
                'name' => 'Aéreo Convencional'
            ],
            [
                'name' => 'Rodoviário'
            ],
            [
                'name' => 'Caminhão Exclusivo'
            ]
        ];

        foreach ($feeTypes as $item) {
            FeeType::query()->firstOrCreate($item);
        }
    }
}
