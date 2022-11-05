<?php

use App\Models\Customer;
use App\Models\CustomerAgent;
use App\Models\Profile;
use App\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = Customer::query()->firstOrCreate(
            [
                'name' => 'David Test',
                'role' => "TI",
                'type' => 'F',
                'gender' => 'M',
                'document' => '08392990447',
                'email' => "davidtest@gmail.com",
                'email_2' => "gina@gmail.com",
                'contact' => "92991531387",
                'contact_2' => "92991531387"
            ]
        );
        $dataUser = [
            'name' => 'Daniel de Sá',
            'email' => "admin@gmail.com",
            'password' => "Abcd@1234",
            'profile_id' => Profile::query()->whereName('agent_customer')->first()->id
        ];

        $user = User::query()->firstOrCreate(
            [
                'name' => $dataUser['name'],
                'email' => $dataUser['email'],
                'password' => $dataUser['password'],
                'profile_id' =>  $dataUser['profile_id']
            ]
        );

        CustomerAgent::query()->firstOrCreate([
            'name' => $dataUser['name'],
            'email' => $dataUser['email'],
            'contact' => "9299153337",
            'user_id' => $user->id,
            'role' => "daniel",
            'customer_id' => $customer->id
        ]);
    }
}
