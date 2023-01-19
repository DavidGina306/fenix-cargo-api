<?php

use App\Helpers\MoneyToDecimal;
use App\Models\Address;
use App\Models\Cabinet;
use App\Models\Customer;
use App\Models\Locale;
use App\Models\ObjectModel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class CabinetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $address = Address::query()->firstOrCreate([
            'address_line_1' => "rua 1",
            'address_line_2' => "adrianopolis",
            'address_line_3' => "",
            'town' => "Manaus",
            'country' => "Brasil",
            'state' => "AM",
            'postcode' => "69000000"
        ]);
        for ($j = 0; $j < rand(5, 25); $j++) {

            $cabinet = Cabinet::query()->firstOrCreate(
                [
                    'order' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'customer_id' => Customer::first()->id,
                    'address_id' => $address->id,
                    'status' => 'R',
                    'doc_value' => MoneyToDecimal::moneyToDecimal(100),
                    'entry_date' => Carbon::now()
                ]
            );
            for ($i = 0; $i < rand(1, 10); $i++) {
                ObjectModel::create(
                    [
                        'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                        'width' => $width = MoneyToDecimal::moneyToDecimal(rand(1, 10)),
                        'height' => $height = MoneyToDecimal::moneyToDecimal(rand(1, 10)),
                        'weight' => MoneyToDecimal::moneyToDecimal(rand(1, 10)),
                        'length' => $length = MoneyToDecimal::moneyToDecimal(rand(1, 10)),
                        'cubed_metric' => $length * $width * $height,
                        'cubed_weight' =>  ($length * $width * $height) / 6000,
                        'quantity' => rand(1, 10),
                        'description' => $faker->word(1),
                        'locale_id' => Locale::query()->first()->id,
                        'cabinet_id' => $cabinet->id
                    ]
                );
            }
        }
    }
}
