<?php

namespace App\Services\AdditionalFee;

use App\Helpers\MoneyToDecimal;
use App\Models\AdditionalFee;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreAdditionalFeeService
{
    public static function store($request)
    {
        try {
            $additionalFee = AdditionalFee::query()->firstOrCreate(
                [
                    'name' => $request['name'],
                    'value' => MoneyToDecimal::moneyToDecimal($request['value'])
                ]
            );
            return $additionalFee->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register AdditionalFee', 500);
        }
    }
}
