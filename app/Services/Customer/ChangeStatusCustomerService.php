<?php

namespace App\Services\Customer;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ChangeStatusCustomerService
{
    public static function changeStatus($customerId)
    {
        try {
            $customer = Customer::query()->findOrFail($customerId);
            $customer->update([
                'status' => $status = $customer->status == 'D' ? 'E' : 'D'
            ]);
            self::changeStatusAgents($customer, $status);
            return new CustomerResource($customer->fresh());
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
            throw new Exception('Error to update Status Customer', 500);
        }
    }


    public static function changeStatusAgents(Customer $customer, $status)
    {
        try {
            foreach ($customer->agents as $agent) {
                $agent->user->update([
                    'status' => $status
                ]);
                $agent->update([
                    'status' => $status
                ]);
            }
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Status Agent Customer ', 500);
        }
    }
}
