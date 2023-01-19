<?php

use App\Models\Locale;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class LocaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $locales = [
            [
                'name' => $faker->word(1)
            ],
            [
                'name' => $faker->word(1)
            ],
            [
                'name' => $faker->word(1)
            ]
        ];

        foreach ($locales as $item) {
           Locale::query()->firstOrCreate($item);
        }
    }
}
