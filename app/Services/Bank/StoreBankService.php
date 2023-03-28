<?php

namespace App\Services\Bank;

use App\Models\Bank;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreBankService
{
    public static function store($request)
    {
        try {
            $packingType = Bank::query()->firstOrCreate(
                [
                    'name' => $request['name'],
                    'code' => $request['code']

                ]
            );
            return $packingType->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Bank', 500);
        }
    }
}
