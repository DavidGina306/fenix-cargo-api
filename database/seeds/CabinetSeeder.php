<?php

use App\Helpers\MoneyToDecimal;
use App\Models\Address;
use App\Models\Cabinet;
use App\Models\Customer;
use App\Models\ObjectModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CabinetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($j = 0; $j < rand(5, 25); $j++) {
            $cabinet = Cabinet::query()->firstOrCreate(
                [
                    'order' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'customer_id' => Customer::first()->id,
                    'address_id' => Address::first()->id,
                    'status' => 'R',
                    'doc_value' => MoneyToDecimal::moneyToDecimal(100),
                    'storage_locale' => "Armazém Abandonado",
                    'entry_date' => Carbon::now()
                ]
            );
            for ($i = 0; $i < rand(1, 10); $i++) {
                ObjectModel::create(
                    [
                        'width' => MoneyToDecimal::moneyToDecimal(rand(1, 10)),
                        'height' => MoneyToDecimal::moneyToDecimal(rand(1, 10)),
                        'length' => MoneyToDecimal::moneyToDecimal(rand(1, 10)),
                        'cubed_weight' => MoneyToDecimal::moneyToDecimal(rand(1, 10)),
                        'quantity' => rand(1, 10),
                        'cabinet_id' => $cabinet->id
                    ]
                );
            }
        }
    }
}
