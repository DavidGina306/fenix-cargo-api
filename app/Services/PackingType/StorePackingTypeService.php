<?php

namespace App\Services\PackingType;

use App\Models\PackingType;
use Exception;
use Illuminate\Support\Facades\Log;

class StorePackingTypeService
{
    public static function store($request)
    {
        try {
            $packingType = PackingType::query()->firstOrCreate(
                [
                    'name' => $request['name']
                ]
            );
            return $packingType->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register PackingType', 500);
        }
    }
}
