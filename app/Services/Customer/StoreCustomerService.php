<?php

namespace App\Services\Customer;

use App\Models\Customer;
use App\Models\CustomerAgent;
use App\Services\User\StoreUserService;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreCustomerService
{
    public static function store($request)
    {
        try {

            $customer = Customer::create(
                [
                    'name' => $request['name'],
                    'role' => $request['role'] ?? "",
                    'type' => $request['type'],
                    'gender' => $request['gender'],
                    'document' => $request['document'],
                    'email' => $request['email'],
                    'email_2' => $request['email_2'] ?? "",
                    'contact' => $request['contact'],
                    'contact_2' => $request['contact_2'] ?? ""
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
            ];
            $user = StoreUserService::store($dataUser);
            CustomerAgent::query()->firstOrCreate([
                'name' => $agent['name'],
                'email' => $agent['email'],
                'contact' => $agent['email'],
                'user_id' => $user->id,
                'role' => $request['role'] ?? "",
                'customer_id' => $customer->id
            ]);
        }

    }



}
