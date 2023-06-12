<?php

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentTypes = [
            [
                'name' => 'Boleto'
            ],
            [
                'name' => 'Cartão de Crédito'
            ],
            [
                'name' => 'PIX'
            ],
            [
                'name' => 'Transferência'
            ],
        ];

        foreach ($paymentTypes as $item) {
            PaymentType::query()->firstOrCreate($item);
        }
    }
}
