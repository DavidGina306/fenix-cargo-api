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
                'name' => 'Caixa de papelão'
            ],
            [
                'name' => 'Pallet'
            ],
            [
                'name' => 'Isopor'
            ],
            [
                'name' => 'Galão/rolo/tubo'
            ],
            [
                'name' => 'Sem embalagem'
            ]
        ];

        foreach ($packingTypes as $item) {
           PackingType::query()->firstOrCreate($item);
        }
    }
}
