<?php

namespace App\Services\Customer;

use App\Models\Customer;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateCustomerService
{
    public static function update($request, $customerId)
    {
        try {
            $customer = Customer::query()->findOrFail($customerId);
            $customer->update(
                [
                    'name' => $request['name'],
                    'role' => $request['role'] ?? "",
                    'type' => $request['type'],
                    'gender' => $request['gender'] ?? "",
                    'document' => $request['document'],
                    'email' => $request['email'],
                    'email_2' => $request['email_2'] ?? "",
                    'contact' => $request['contact'],
                    'contact_2' => $request['contact_2'] ?? ""
                ]
            );
            return $customer->fresh();
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Customer':
                    throw new Exception('Customer not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Customer', 500);
        }
    }
}
