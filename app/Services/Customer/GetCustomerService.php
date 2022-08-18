<?php

namespace App\Services\Customer;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetCustomerService
{
    public static function get($customerId)
    {
        try {
            $customer = Customer::query()->findOrFail($customerId);
            return new CustomerResource($customer);
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
            throw new Exception('Error to get Customer', 500);
        }
    }
}
