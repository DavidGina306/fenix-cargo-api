<?php

use App\Models\DocType;
use Illuminate\Database\Seeder;

class DocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $docTypes = [
            [
                'name' => 'Nota fiscal'
            ],
            [
                'name' => 'CTE'
            ],
            [
                'name' => 'Declaração'
            ]
        ];

        foreach ($docTypes as $item) {
           DocType::query()->firstOrCreate($item);
        }
    }
}
