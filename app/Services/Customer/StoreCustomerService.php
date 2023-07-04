<?php

namespace App\Services\Customer;

use App\Helpers\GenderHelper;
use App\Models\Customer;
use App\Models\CustomerAgent;
use App\Models\Profile;
use App\Services\Address\StoreAddressService;
use App\Services\User\StoreUserService;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreCustomerService
{
    public static function store($request)
    {
        try {
            $address = StoreAddressService::store($request['address']);
            $customer = Customer::create(
                [
                    'name' => $request['name'],
                    'role' => $request['role'] ?? "",
                    'type' => $request['type'],
                    'gender' => isset($request['gender']) ? GenderHelper::getGenderValue($request['gender']) : null,
                    'document' => $request['document'],
                    'document_2' => $request['document_2'],
                    'address_id' => $address->id
                ]
            );
            self::storeAgents($request['agents'], $customer);
            return $customer->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Customer', 500);
        }
    }

    public static function storeAgents($agents, Customer $customer)
    {
        foreach ($agents as $agent) {
            $dataUser = [
                'name' => $agent['name'],
                'email' => $agent['email'],
                'password' => "Abcd@1234",
                'profile_id' => Profile::query()->whereName('agent_customer')->first()->id
            ];
            $user = StoreUserService::store($dataUser);
            CustomerAgent::query()->firstOrCreate([
                'name' => $agent['name'],
                'email' => $agent['email'],
                'departament' => $agent['departament'],
                'contact' => $agent['contact'],
                'user_id' => $user->id,
                'role' => $request['role'] ?? "",
                'customer_id' => $customer->id
            ]);
        }

    }



}
