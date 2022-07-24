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
                'name' => 'Urgente 24h'
            ],
            [
                'name' => 'Comum'
            ],
            [
                'name' => 'Caminhão exclusivo'
            ],
            [
                'name' => 'Tabela de parceiro'
            ]
        ];

        foreach ($feeTypes as $item) {
            FeeType::query()->firstOrCreate($item);
        }
    }
}
