<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(StatusesSeeder::class);
        $this->call(UserMasterSeeder::class);
        $this->call(DocTypeSeeder::class);
        $this->call(FeeTypeSeeder::class);
        $this->call(PackingTypeSeeder::class);
        $this->call(ProfileSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(FeeRuleSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(LocaleSeeder::class);
        $this->call(AdditionalFeeSeeder::class);
        $this->call(CabinetSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(CountrySeeder::class);
    }
}
