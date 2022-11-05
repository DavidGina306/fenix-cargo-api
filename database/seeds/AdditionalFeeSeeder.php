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
                'name' => 'Embalagem',
                'value' => 10
            ],
            [
                'name' => 'Ajudante',
                'value' => 30
            ],
            [
                'name' => 'Shipper declaration com etiqueta',
                'value' => 30
            ],
            [
                'name' => 'Caixa homologada com certificado',
                'value' => 30
            ],
            [
                'name' => 'Área de risco',
                'value' => 30
            ],
            [
                'name' => 'Gelo',
                'value' => 30
            ]
        ];


        foreach ($additionalFees as $item) {
            AdditionalFee::query()->firstOrCreate($item);
        }
    }
}
