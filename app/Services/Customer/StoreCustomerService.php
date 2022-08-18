<?php

namespace App\Services\Customer;

use App\Models\Customer;
use App\Services\User\StoreUserService;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreCustomerService
{
    public static function store($request)
    {
        try {
            $dataUser = [
                'name' => $request['user_name'],
                'email' => $request['email'],
                'password' => $request['password'],
            ];
            $user = StoreUserService::store($dataUser);
            $partner = Customer::create(
                [
                    'name' => $request['name'],
                    'role' => $request['role'] ?? "",
                    'type' => $request['type'],
                    'gender' => $request['gender'],
                    'document' => $request['document'],
                    'email' => $request['email'],
                    'email_2' => $request['email_2'] ?? "",
                    'contact' => $request['contact'],
                    'contact_2' => $request['contact_2'] ?? "",
                    'user_id' => $user->id
                ]
            );
            return $partner->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Customer', 500);
        }
    }
}
