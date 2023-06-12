<?php

namespace App\Services\PaymentType;

use App\Models\PaymentType;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectPaymentTypeService
{
    public static function search($request)
    {
        try {
            $response =  PaymentType::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Profile', 500);
        }
    }
}
