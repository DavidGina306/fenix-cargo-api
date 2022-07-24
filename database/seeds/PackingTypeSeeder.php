<?php

use App\Models\PackingType;
use Illuminate\Database\Seeder;

class PackingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $packingTypes = [
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

        foreach ($packingTypes as $item) {
           PackingType::query()->firstOrCreate($item);
        }
    }
}
