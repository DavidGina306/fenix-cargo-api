<?php

use App\User;
use Illuminate\Database\Seeder;

class UserMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->firstOrCreate([
            'name' => 'admin',
            'photo' => 'https://cdn-icons-png.flaticon.com/512/1089/1089129.png',
            'email' => 'admin@fenixcargo.com',
            'password' => 'Abc@1234',
        ]);
    }
}
