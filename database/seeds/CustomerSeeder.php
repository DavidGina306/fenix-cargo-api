<?php

use App\Models\Address;
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
        $address = Address::query()->firstOrCreate(
            [
                'address_line_1' => 'address_line_1',
                'address_line_2' => 'address_line_2',
                'address_line_3' => 'address_line_3',
                'town' => 'town',
                'country' => 'Brasil',
                'state' => 'PE',
                'postcode' => '52060090'
            ]
        );
        $customer = Customer::query()->firstOrCreate(
            [
                'name' => 'David Test',
                'role' => "TI",
                'type' => 'F',
                'gender' => 'M',
                'document' => '08392990447',
                "address_id" => $address->id
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
