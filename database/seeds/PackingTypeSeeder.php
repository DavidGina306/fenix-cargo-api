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
                'name' => 'Papelao'
            ],
            [
                'name' => 'Embalagem Plástica'
            ]
        ];

        foreach ($packingTypes as $item) {
           PackingType::query()->firstOrCreate($item);
        }
    }
}
