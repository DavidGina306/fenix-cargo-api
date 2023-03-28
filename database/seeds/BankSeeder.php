<?php

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $banks = [
            ['code' => '001', 'name' => 'Banco do Brasil'],
            ['code' => '237', 'name' => 'Bradesco'],
            ['code' => '341', 'name' => 'Itaú'],
            ['code' => '104', 'name' => 'Caixa Econômica Federal'],
            ['code' => '033', 'name' => 'Santander'],
            ['code' => '745', 'name' => 'Citibank'],
            ['code' => '399', 'name' => 'HSBC'],
            ['code' => '104', 'name' => 'Caixa Econômica Federal'],
            ['code' => '633', 'name' => 'Banco Rendimento'],
            ['code' => '422', 'name' => 'Banco Safra'],
            ['code' => '070', 'name' => 'BRB - Banco de Brasília'],
            ['code' => '104', 'name' => 'Caixa Econômica Federal'],
            ['code' => '755', 'name' => 'Banco Merrill Lynch'],
            ['code' => '488', 'name' => 'JPMorgan Chase Bank'],
            ['code' => '070', 'name' => 'BRB - Banco de Brasília'],
            ['code' => '477', 'name' => 'Citibank'],
            ['code' => '008', 'name' => 'Santander Banespa'],
            ['code' => '707', 'name' => 'Banco Daycoval'],
            ['code' => '025', 'name' => 'Banco Alfa'],
            ['code' => '633', 'name' => 'Banco Rendimento'],
            ['code' => '077', 'name' => 'Banco Inter'],
            ['code' => '136', 'name' => 'Unicred'],
            ['code' => '128', 'name' => 'MS Bank'],
            ['code' => '021', 'name' => 'Banestes'],
            ['code' => '655', 'name' => 'Banco Votorantim'],
            ['code' => '064', 'name' => 'Goldman Sachs'],
            ['code' => '082', 'name' => 'Banco Topázio'],
            ['code' => '069', 'name' => 'BPN Brasil'],
            ['code' => '062', 'name' => 'Hipercard'],
            ['code' => '260', 'name' => 'Nu Pagamentos S.A.'],
            ['code' => '290', 'name' => 'Pagseguro Internet S.A.'],
            ['code' => '077', 'name' => 'Banco Inter'],
        ];

        foreach ($banks as $bank) {
            Bank::query()->firstOrCreate($bank);
        }
    }
}
