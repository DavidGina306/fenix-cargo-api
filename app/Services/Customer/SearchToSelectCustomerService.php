<?php

namespace App\Services\Customer;

use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectCustomerService
{
    public static function search($request)
    {
        try {
            $response =  Customer::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Customer', 500);
        }
    }
}
